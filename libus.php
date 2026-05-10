<?php

// ====================
// CONFIGURATION
// ====================
const CONFIG = [
    'db_host' => 'localhost',
    'db_user' => 'root',
    'db_pass' => '',
    'db_name' => 'db_contacts',
    'website_name' => 'Test Website',
    'base_url' => 'localhost',
    'timezone' => 'Asia/Karachi',
];

// ====================
// DATABASE CONNECTION (PDO)
// ====================
/**
 * @return PDO
 * @throws Exception
 */
function getDbConnection(): PDO
{
    $dsn = "mysql:host=" . CONFIG['db_host'] . ";dbname=" . CONFIG['db_name'] . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    date_default_timezone_set(CONFIG['timezone']);
    return new PDO($dsn, CONFIG['db_user'], CONFIG['db_pass'], $options);
}

// ====================
// SELECT QUERY
// ====================
/**
 * Execute a SELECT query and return the result as associative array.
 *
 * @param string $sql
 * @param array $params
 * @return array|null
 * @throws Exception
 */
function selectQuery(string $sql, array $params = []): ?array
{
    $conn = getDbConnection();
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $data = $stmt->fetchAll();
    return $data ?: null;
}

// ====================
// INSERT/UPDATE/DELETE QUERY
// ====================
/**
 * Execute a write query (INSERT, UPDATE, DELETE)
 *
 * @param string $sql
 * @param array $params
 * @return bool
 * @throws Exception
 */
function iudQuery(string $sql, array $params = []): bool
{
    $conn = getDbConnection();
    $stmt = $conn->prepare($sql);
    return $stmt->execute($params);
}

// ====================
// TRANSACTIONAL MULTI-QUERY
// ====================
/**
 * Execute multiple queries within a transaction.
 *
 * @param array $queries Each query should have 'sql' and 'params' keys.
 * @return bool
 * @throws Exception
 */
function transactionQuery(array $queries): bool
{
    $conn = getDbConnection();
    $conn->beginTransaction();

    try {
        foreach ($queries as $q) {
            if (!isset($q['sql'])) {
                throw new Exception("Each query must have a 'sql' key.");
            }
            $stmt = $conn->prepare($q['sql']);
            $stmt->execute($q['params'] ?? []);
        }

        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollBack();
        throw $e;
    }
}

?>
