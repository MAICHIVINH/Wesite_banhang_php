<?php
require_once './config/database.php';

abstract class Model
{
    protected $pdo;
    protected $table;
    protected $fields = [];
    protected $foreignKeys = [];

    public function __construct()
    {
        $this->pdo = Database::getInstance();
        $this->setTableName();
    }

    protected function setTableName()
    {
        if (!$this->table) {
            $this->table = strtolower(get_class($this)) . "s";
        }
    }

    public function createTable()
    {
        // kiểm tra bảng có tồn tại chưa
        $stmt = $this->pdo->prepare("SHOW TABLES LIKE :table");
        $stmt->execute(['table' => $this->table]);
        $tableExists = $stmt->fetch();

        if (!$tableExists) {
            // Nếu bảng chưa tồn tại thì tạo mới hoàn toàn

            $columns = [];

            foreach ($this->fields as $name => $type) {
                $columns[] = "$name $type";
            }

            if (!empty($this->foreignKeys)) {
                foreach ($this->foreignKeys as $col => $ref) {
                    $columns[] = "FOREIGN KEY ($col) REFERENCES $ref";
                }
            }


            $columns_sql = implode(", ", $columns);
            $sql = "CREATE TABLE {$this->table} ({$columns_sql})";
            $this->pdo->exec($sql);
        } else {
            // Nếu bảng đã có thì kiểm tra và thêm cột mới
            $stmt = $this->pdo->query("DESCRIBE {$this->table}");
            $existingColumns = $stmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($this->fields as $name => $type) {
                if (!in_array($name, $existingColumns)) {
                    $sql = "ALTER TABLE {$this->table} ADD COLUMN {$name} {$type}";
                    $this->pdo->exec($sql);
                    echo "Added column {$name} to table {$this->table}.<br>";
                }
            }
        }
    }


    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} WHERE isDeleted = 0");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function allDeleted()
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} WHERE isDeleted = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id AND isDeleted = 0");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findIsDeled($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function existsByName($name): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM {$this->table} WHERE name = :name AND isDeleted = 0");
        $stmt->execute(['name' => $name]);
        return $stmt->fetchColumn() > 0;
    }

    public function getByColumn(string $column, $value): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countDeleted(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM {$this->table} WHERE isDeleted = 1");
        return (int) $stmt->fetchColumn();
    }



    public function existsByNameExceptId($id, $name): bool
    {
        $name = trim(mb_strtolower($name));

        $sql = "SELECT COUNT(*) FROM {$this->table} 
            WHERE LOWER(TRIM(name)) = :name AND id != :id AND isDeleted = 0";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }


    public function insert($data): mixed
    {
        $columns = implode(",", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($columns) VALUES ($values)");
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data)
    {
        $setParts = [];
        foreach ($data as $column => $value) {
            $setParts[] = "$column = :$column";
        }

        $setClause = implode(", ", $setParts);

        $data['id'] = $id;

        $sql = "UPDATE {$this->table} SET $setClause WHERE id = :id AND isDeleted = 0";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($data);
    }

    public function updateIsDeleted($id, $data)
    {
        $setParts = [];
        foreach ($data as $column => $value) {
            $setParts[] = "$column = :$column";
        }

        $setClause = implode(", ", $setParts);

        $data['id'] = $id;

        $sql = "UPDATE {$this->table} SET $setClause WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function deleteByColumn(string $column, $value): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE {$column} = :value";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['value' => $value]);
    }

    public function updateDeletedByColumn($column, $id)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET isDeleted = 1 WHERE  {$column} = :value");
        return $stmt->execute(['value' => $id]);
    }

    public function updateNotDeletedByColumn($column, $id)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET isDeleted = 0 WHERE  {$column} = :value");
        return $stmt->execute(['value' => $id]);
    }


    public function updateDeleted($id)
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET isDeleted = 1 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
