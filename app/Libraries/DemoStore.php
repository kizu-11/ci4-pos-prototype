<?php

namespace App\Libraries;

/** Temporary database-free store for the hosted classroom demonstration. */
class DemoStore
{
    public function __construct(private string $name) {}

    public function all(): array { return $this->read(); }

    public function find(int $id): ?array
    {
        foreach ($this->read() as $row) {
            if ((int) ($row['id'] ?? 0) === $id) return $row;
        }
        return null;
    }

    public function insert(array $data): int
    {
        $rows = $this->read();
        $ids = array_map(static fn (array $row): int => (int) ($row['id'] ?? 0), $rows);
        $data['id'] = $ids ? max($ids) + 1 : 1;
        $rows[] = $data;
        $this->write($rows);
        return $data['id'];
    }

    public function update(int $id, array $data): bool
    {
        $rows = $this->read();
        foreach ($rows as $index => $row) {
            if ((int) ($row['id'] ?? 0) === $id) {
                $rows[$index] = array_merge($row, $data, ['id' => $id]);
                $this->write($rows);
                return true;
            }
        }
        return false;
    }

    public function hasValue(string $field, string $value, ?int $exceptId = null): bool
    {
        foreach ($this->read() as $row) {
            if ($exceptId !== null && (int) ($row['id'] ?? 0) === $exceptId) continue;
            if (strcasecmp(trim((string) ($row[$field] ?? '')), trim($value)) === 0) return true;
        }
        return false;
    }

    private function path(): string { return WRITEPATH . 'data/' . $this->name . '.json'; }

    private function read(): array
    {
        $path = $this->path();
        if (! is_file($path)) {
            $defaults = $this->defaults();
            $this->write($defaults);
            return $defaults;
        }
        $decoded = json_decode((string) file_get_contents($path), true);
        return is_array($decoded) ? $decoded : [];
    }

    private function write(array $rows): void
    {
        $directory = dirname($this->path());
        if (! is_dir($directory)) mkdir($directory, 0755, true);
        file_put_contents($this->path(), json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);
    }

    private function defaults(): array
    {
        if ($this->name === 'users') {
            return [
                ['id' => 1, 'username' => 'admin', 'full_name' => 'System Administrator', 'avatar' => '', 'created_at' => date('Y-m-d H:i:s')],
                ['id' => 2, 'username' => 'johnny', 'full_name' => 'Johnny Bravo', 'avatar' => '', 'created_at' => date('Y-m-d H:i:s')],
            ];
        }
        return [['id' => 1, 'full_name' => 'Maria Santos', 'email' => 'maria@example.com', 'phone' => '09171234567', 'created_at' => date('Y-m-d H:i:s')]];
    }
}
