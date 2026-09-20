<?php

require_once  './core/Models.php';

class RoleEmployee extends Model
{
    protected $table = 'role_employee';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'employee_id' => 'INT NOT NULL',
        'role_id' => 'INT NOT NULL',
        'isDeleted' => 'TINYINT(1)',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];

    protected $foreignKeys = [
        'employee_id' => 'employees(id)',
        'role_id' => 'roles(id)'
    ];

    public function getByEmployeeId($employeeId)
    {
        $sql = "SELECT role_id FROM role_employee WHERE employee_id = :employee_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['employee_id' => $employeeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteByEmployee($employeeId)
    {
        $sql = "DELETE FROM {$this->table} WHERE employee_id = :employee_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['employee_id' => $employeeId]);
    }
}
