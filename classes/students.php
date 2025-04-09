<?php
class Student {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function paginate(int $page = 1, int $perPage = 10): array {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->pdo->prepare(
            "SELECT s.*, sec.designation as section_name 
             FROM student s 
             LEFT JOIN section sec ON s.section_id = sec.id
             LIMIT :offset, :perPage"
        );
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->pdo->prepare(
            "SELECT s.*, sec.designation as section_name 
             FROM student s 
             LEFT JOIN section sec ON s.section_id = sec.id 
             WHERE s.id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO student (name, birthday, section_id, image) 
             VALUES (:name, :birthday, :section_id, :image)"
        );
        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE student SET 
             name = :name, 
             birthday = :birthday, 
             section_id = :section_id, 
             image = :image 
             WHERE id = :id"
        );
        return $stmt->execute(array_merge($data, ['id' => $id]));
    }

    public function delete(int $id): bool {
        $student = $this->find($id);
        if ($student && $student['image']) {
            @unlink(UPLOAD_DIR . $student['image']);
        }
        $stmt = $this->pdo->prepare("DELETE FROM student WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function count(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM student");
        return (int)$stmt->fetchColumn();
    }
}
?>