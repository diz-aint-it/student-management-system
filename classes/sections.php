<?php
class Section {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function all(): array {
        $stmt = $this->pdo->query("SELECT * FROM section ORDER BY designation");
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM section WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO section (designation, description) 
             VALUES (:designation, :description)"
        );
        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE section SET 
             designation = :designation, 
             description = :description 
             WHERE id = :id"
        );
        return $stmt->execute(array_merge($data, ['id' => $id]));
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM section WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function countStudents(int $sectionId): int {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM student WHERE section_id = ?"
        );
        $stmt->execute([$sectionId]);
        return (int)$stmt->fetchColumn();
    }
}
?>