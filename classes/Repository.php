<?php
class Repository {
    protected $pdo;
    protected $table;

    public function __construct(PDO $pdo, string $table) {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function all(): array {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool {
        $set = implode(', ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($data)));
        $sql = "UPDATE {$this->table} SET $set WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array_merge($data, ['id' => $id]));
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function count(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM {$this->table}");
        return (int) $stmt->fetchColumn();
    }

    public function paginate(int $page = 1, int $perPage = 10): array {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} LIMIT :offset, :perPage");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>