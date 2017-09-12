<?php
namespace MapasCulturais\Traits;

/**
 * Defines the magic getter method the be used when trying to get a protected or private property.
 *
 * If a getter method with the same name of the property exists, for example **set*PropertyName***, then returns it,
 * else if the property name doesn't start with an undercore returns the value of the property directly.
 * Otherwise returns null.
 */
trait MagicGetter{
    /**
    * If a getter method with the same name of the property exists, for example **set*PropertyName***, then returns it,
    * Else if the property name doesn't start with an undercore returns the value of the property directly.
    * Otherwise returns null.
     */
    public function __get($name){

        if(property_exists($this, 'container') && $val = $this->container[$name]){
            $value =  $val;
        }elseif(method_exists($this, 'get' . $name)){
            $getter = 'get' . $name;
            $result = $this->$getter();
            $value =  $result;

        }else if($name[0] !== '_' && property_exists($this, $name)){
            $value =  $this->$name;

        }else if(method_exists($this,'usesMetadata') && $this->usesMetadata()){
            $value =  $this->__metadata__get($name);

        }else{
            $value = null;

        }

        if($this instanceof \MapasCulturais\Entity && is_string($value)){
            $class = $this->getClassName();
            $value = $class::processPropertyValue($name, $value);
        }

        return $value;
    }

    /**
     * This class uses MagicGetter
     * @return true
     */
    public static function usesMagicGetter (){
        return true;
    }
}