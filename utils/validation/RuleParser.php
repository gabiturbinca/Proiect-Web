<?php

class RuleParser {
    private array $ruleMap = [
        'required' => RequiredRule::class,
        'email' => EmailRule::class,
        'min' => MinRule::class,
        'max' => MaxRule::class,
        'alpha_num' => AlphaNumRule::class,
        'confirmed' => ConfirmedRule::class,
        'numeric_id' => NumericIdRule::class,
        'numeric_min' => NumericMinRule::class,
        'numeric_max' => NumericMaxRule::class 
    ];
    public function parse(string |Rule $rule):Rule {
        if($rule instanceof Rule)
            return $rule;
        $ruleName = $rule;
        $args = [];
        if(str_contains($rule,':')) {
            [$ruleName, $argStr] = explode(':', $rule,2);
            $args = explode(',', $argStr);
        }
        if(!isset($this->ruleMap[$ruleName]))
            throw new InvalidArgumentException("$rule does not exist");
        $class = $this->ruleMap[$ruleName];
        return new $class(...$args);
    }
    public function parseRuleArray(array $rule):array {
        return array_map(fn(string |Rule $rul) => $this->parse($rul), $rule);
    }

    public function addRule(string $ruleName, string $ruleClass) {
        if(!is_subclass_of($ruleClass, Rule::class)) {
            throw new InvalidArgumentException("$ruleClass must implement Rule");
        }
        $this->ruleMap[$ruleName] = $ruleClass;
    }
}