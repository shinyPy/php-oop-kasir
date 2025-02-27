<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
class DB
{
    private $host;
    private $username;
    private $password;
    private $database;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->database = $_ENV['DB_DATABASE'];
    }

    private $connection;

    private function connect()
    {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    private function disconnect()
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }

    private function query($sql)
    {
        $this->connect();
        $result = $this->connection->query($sql);
        $this->disconnect();

        return $result;
    }

    private function escapeString($value)
    {
        $this->connect();
        $escapedValue = $this->connection->real_escape_string($value);
        $this->disconnect();

        return $escapedValue;
    }

    private function setSessionUser($id)
    {
        $sql = "SELECT * FROM user WHERE id = '$id'";
        $result = $this->query($sql);

        $user = $result->fetch_assoc();

        $_SESSION['user'] = $user;

        return true;
    }

    private function swal($icon = "", $title = "", $text = "")
    {
        echo "<script> Swal.fire({icon: '$icon',title: '$title', text:'$text'})</script>";
    }

    public function insert($table, $data, $status = false)
    {
        $columns = implode(", ", array_keys($data));
        $values = implode("', '", array_map([$this, 'escapeString'], array_values($data)));

        $sql = "INSERT INTO $table ($columns) VALUES ('$values')";

        $this->connect();
        $result = $this->connection->query($sql);
        if ($status) {
            return $result;
        }
        $lastInsertedId = $this->connection->insert_id;
        $this->disconnect();

        return $lastInsertedId;
    }

    public function select($table, $columns = "*", $condition = "", $joinTable = "", $joinCondition = "", $orderByColumn = "", $orderBy = "ASC")
    {
        $sql = "SELECT $columns FROM $table";

        if ($joinTable !== "" && $joinCondition !== "") {
            $sql .= " JOIN $joinTable ON $joinCondition";
        }

        if ($condition !== "") {
            $sql .= " WHERE $condition";
        }

        if ($orderByColumn !== "") {
            if ($orderBy !== "ASC") {
                $sql .= " ORDER BY $orderByColumn $orderBy";
            } else {
                $sql .= " ORDER BY $orderByColumn $orderBy";
            }
        }

        $result = $this->query($sql);

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }


    public function update($table, $data, $condition)
    {
        $setClause = implode(", ", array_map(function ($key, $value) {
            return "$key = '$value'";
        }, array_keys($data), array_values($data)));

        $sql = "UPDATE $table SET $setClause WHERE $condition";
        return $this->query($sql);
    }

    public function delete($table, $condition)
    {
        $sql = "DELETE FROM $table WHERE $condition";
        return $this->query($sql);
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = $this->query($sql);

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            if ($user['status'] === 'nonaktif') {
                return $this->swal('error', 'Gagal!', 'Aktivasi akun terlebih dahulu! Silahkan lapor ke admin');
            }

            $this->setSessionUser($user['id']);
            return true;
        } else {
            return $this->swal('error', 'Gagal!', 'Email atau Password salah!');
        }
    }
}
