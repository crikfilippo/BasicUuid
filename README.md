A simple php class to generate and validate UUIDs (V4).

# Usage

Generate new UUID:
```php
$uuid = new BasicUuid();
echo $uuid;
//or
$uuid = BasicUuid::generate();
echo $uuid;
```

Instance from string:
```php
$uuid = new BasicUuid('123e4567-e89b-12d3-a456-426614174000');
//or
$uuid = new BasicUuid('123e4567e89b12d3a456426614174000');
```

Validate UUID format (implicitly done when instancing):
```php
$uuid1 = '123e4567-e89b-12d3-a456-426614174000';
$isUuid1Valid = BasicUuid::valid($uuid1);
//or
$uuid2 = '123e4567e89b12d3a456426614174000';
$isUuid2Valid = BasicUuid::valid($uuid2);
```

Add/Remove dashes (chained or static)
```php
$uuid = new BasicUuid('123e4567-e89b-12d3-a456-426614174000');
echo $uuid->removeDashes();
echo $uuid->addDashes();
echo $uuid->removeDashes()->addDashes();
//or
$uuid1 = '123e4567-e89b-12d3-a456-426614174000';
echo BasicUuid::removeDashes($uuid1);
//or
$uuid2 = new BasicUuid('123e4567-e89b-12d3-a456-426614174000');
echo BasicUuid::removeDashes($uuid2);
```


