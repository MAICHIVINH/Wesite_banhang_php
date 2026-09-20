<?php

require_once  './core/Models.php';

class EmployeeMenu extends Model
{
    protected $table = 'employee_menu';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'employee_id' => 'INT NOT NULL',
        'menu_id' => 'INT NOT NULL',
        'isDeleted' => 'TINYINT(1)',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];

    protected $foreignKeys = [
        'employee_id' => 'employees(id)',
        'menu_id' => 'menus(id)'
    ];

    public function getByEmployeeId($id)
    {
        $sql = 'SELECT * FROM employees e JOIN  employee_menu em ON e.id = em.employee_id
                                            JOIN menus m ON em.menu_id = m.id
                                            WHERE e.isDeleted = 0
                                            AND  em.isDeleted = 0
                                            AND  m.isDeleted = 0
                                            AND e.id = :employee_id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['employee_id' => $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIdByEmployeeId($id)
    {
        $sql = "SELECT menu_id FROM employee_menu WHERE employee_id = :employee_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['employee_id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteByEmployee($employeeId)
    {
        $sql = "DELETE FROM {$this->table} WHERE employee_id = :employee_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['employee_id' => $employeeId]);
    }
}
