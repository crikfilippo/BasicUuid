A simple php class to generate and validate UUIDs (V8).

# Usage

Generate new UUID:
```php
$uuid = new BasicUuid();
//or
$uuid = BasicUuid::generate();
//or
$uuid = new BasicUuid('123e4567-e89b-12d3-a456-426614174000');
$uuid = new BasicUuid('123e4567e89b12d3a456426614174000');
//printing
echo $uuid;
```

Validate UUID format (implicitly done when instancing):
```php
$uuid1 = '123e4567-e89b-12d3-a456-426614174000';
$isUuid1Valid = BasicUuid::validate($uuid1);
//or
$uuid2 = new BasicUuid();
$isUuid2Valid = BasicUuid::validate($uuid2);
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


