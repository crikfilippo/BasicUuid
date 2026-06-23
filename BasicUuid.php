<?php

namespace BasicUuid;

/**
 * A simple PHP class to generate and validate UUIDs (V4 with Unix timestamp prefix)
 * 
 * @method self removeDashes() Remove dashes from UUID format
 * @method self addDashes() Add dashes to UUID format
 * @method static self removeDashes(string|self $uuid) Remove dashes from UUID format
 * @method static self addDashes(string|self $uuid) Add dashes to UUID format
 * @method static self new() Generate new UUID with Unix timestamp prefix
 * @method static bool valid(null|string|self $uuid) Validate UUID format
 */
class BasicUuid implements \Stringable
{
	
	private string $value;
    public bool $hasDashes;

    public function __construct(null|string|self $value = 'NEW') {
        if( ! is_null($value) && is_string($value) && $value === 'NEW'){ $this->value = (string)self::new(); return; }
        if( ! self::valid($value)) {  throw new \InvalidArgumentException("Invalid UUID"); }
        $this->value = (string)$value;
        $this->hasDashes = str_contains($this->value,'-');
    }
    
    public function __toString(): string {
        return $this->value;
    }

    public function __call(string $name, array $arguments){

        if($name == 'removeDashes'){ 
            $this->value = (string)self::_removeDashes($this->value); 
            $this->hasDashes = false; 
            return $this; 
        }

        if($name == 'addDashes'){ 
            $this->value = (string)self::_addDashes($this->value); 
            $this->hasDashes = true; 
            return $this; 
        }
    }

    public static function __callStatic(string $name, array $arguments) {
        if($name == 'removeDashes'){ return self::_removeDashes(...$arguments); }
        if($name == 'addDashes'){ return self::_addDashes(...$arguments); }
    }
    
    public static function new(): self {
        $data = random_bytes(16);
		$time = time();
	    $data[0] = chr(($time >> 24) & 0xff);
	    $data[1] = chr(($time >> 16) & 0xff);
	    $data[2] = chr(($time >> 8) & 0xff);
	    $data[3] = chr($time & 0xff);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return new self(vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)));
    }

    public static function valid(null|string|self $uuid = null): bool {
    	if( is_null($uuid) ){ return false; }
    	$uuid = (string)$uuid;
        $len = strlen($uuid);
        if($len < 32){ return false; }
		if(preg_match('/[A-Z]/', $uuid)){ return false; }
        $hasDashes = str_contains($uuid, '-');
        if( $hasDashes ){ //dashed
            if(strlen($uuid) !== 36){ return false; }
	        if(!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $uuid)){  return false; }
        } 
        else{ //not dashed
	        if($len !== 32){ return false; }
            if(!preg_match('/^[0-9a-f]{32}$/', $uuid)){  return false; }
        }
        return true;
    }

    public static function _removeDashes(null|string|self $uuid = null): self {
    	if( ! self::valid($uuid) ){ throw new \Exception('invalid uuid.'); } 
		if( ! str_contains($uuid,'-')){ return new self($uuid); }
        return new self(str_replace('-', '', $uuid));
    }
    
    public static function _addDashes(null|string|self $uuid = null): self {
    	if( ! self::valid($uuid) ){ throw new \Exception('invalid uuid.'); } 
    	if(str_contains($uuid,'-')){ return new self($uuid); }
    	return new self(substr($uuid,0,8).'-'.substr($uuid,8,4).'-'.substr($uuid,12,4).'-'.substr($uuid,16,4).'-'.substr($uuid,20));
    }

}
