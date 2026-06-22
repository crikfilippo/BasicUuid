A simple php class to generate and validate UUIDs (V8).
<br><br>Notes:
<br>- Single file class, no dependencies.
<br>- RFC 4122 compliant UUID V8 generation.
<br>- Fast and lightweight validation.

# Usage

1. Include class in your project and set custom namespace (optional):
```php
require 'BasicUuid.php';
```

2. Generate new UUID:
```php
$uuid = BasicUuid::generate();
```

3. Validate UUID format:
```php
$isValid = BasicUuid::validate($uuid);
```

4. Generate UUID with custom namespace:
```php
$uuid = BasicUuid::generate('my-custom-namespace');
```

5. Get UUID details:
```php
$version = BasicUuid::getVersion($uuid);
$variant = BasicUuid::getVariant($uuid);
```

# Examples

### Basic generation
```php
$uuid = BasicUuid::generate();
echo $uuid; // outputs: 550e8400-e29b-41d4-a716-446655440000
```

### Validation
```php
$uuid = '550e8400-e29b-41d4-a716-446655440000';
if (BasicUuid::validate($uuid)) {
    echo 'Valid UUID';
}
```

### Database usage
```php
// Generate UUID for new record
$id = BasicUuid::generate();
$stmt = $pdo->prepare('INSERT INTO users (id, name) VALUES (?, ?)');
$stmt->execute([$id, 'John Doe']);

// Validate user ID before query
if (BasicUuid::validate($_GET['userId'])) {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_GET['userId']]);
}
```

### API responses
```php
$response = [
    'id' => BasicUuid::generate(),
    'timestamp' => time(),
    'data' => []
];
echo json_encode($response);
```

# Demo

Include `demo.php` and `BasicUuid.php` to test all features.
Remove demo file when no longer needed.
