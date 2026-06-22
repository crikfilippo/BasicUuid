<?php

namespace BasicUuid;

class BasicUuid implements \Stringable
{
	
	public static ?string $staticValue = null;

    public function __construct(private ?string $value = null, bool $dashLess = false) {
        if (empty($value)) { $this->value = (string)self::new($dashLess); }
        else{ 
			$value = strtolower($value); 
			if( ! self::valid($value)) {  throw new \InvalidArgumentException("Invalid UUID"); }
			$this->value = $value;
		}
        self::$staticValue = $value; 
    }
    
    public function __toString(): string {
        return $this->value;
    }
    
    public static function new(bool $dashLess = false): self {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        if($dashLess){ return new self(vsprintf('%s%s%s%s%s%s%s%s', str_split(bin2hex($data), 4))); }
        return new self(vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)));
    }

    public static function valid(?string $uuid = null): bool {
    	if( ! is_null($uuid) ){ $value = $uuid; }
    	else{ $value = self::$staticValue; if( is_null($value) ){ return false; } }
		if(preg_match('/[A-Z]/', $value)){ return false; }
    	//dashed
        if( ! str_contains($value, '-')){
            if(strlen($value) !== 32){ return false; }
            if(!preg_match('/^[0-9a-f]{32}$/', $value)){  return false; }
        } 
        //not dashed
        else{
	        if(strlen($value) !== 36){ return false; }
	        if(!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $value)){  return false; }
        }
        return true;
    }

    public static function removeDashes(?string $uuid = null): self {
    	if( ! is_null($uuid) ){ $value = $uuid; if( ! self::valid($value) ){ throw new \Exception('invalid uuid.'); } }
    	else{ $value = self::$staticValue; if( is_null($value) ){ throw new \Exception('uuid not initialized.'); } }
		if( ! str_contains($value,'-')){ return new self($value); }
        return new self(str_replace('-', '', $value));
    }
    
    public static function addDashes(?string $uuid = null): self {
    	if( ! is_null($uuid) ){ $value = $uuid; if( ! self::valid($value) ){ throw new \Exception('invalid uuid.'); } }
    	else{ $value = self::$staticValue; if( is_null($value) ){ throw new \Exception('uuid not initialized.'); } }
    	if(str_contains($value,'-')){ return new self($value); }
    	return new self(substr($value,0,8).'-'.substr($value,8,4).'-'.substr($value,12,4).'-'.substr($value,16,4).'-'.substr($value,20));
    }

}

