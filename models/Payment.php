<?php
require_once  './core/Models.php';

class Payment extends Model
{
    protected $table = 'payments';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'method' => 'VARCHAR(50)',
        'status' => 'VARCHAR(50)',
        'paid_at' => 'DATETIME'
    ];

    public function update($id, $data)
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
}
