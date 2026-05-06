<?php

class Validator {

    private array $rules = [];//are reguli parsate, clase
    private array $data = [];
    private array $errors = [];//erorile date de validator
    private bool $hasRun = false;
    private function __construct(array $data, array $rules) {
        $this->rules = $rules;
        $this->data = $data;
    }
    public static function make(array $data,array $rules):self {
        $parser = new RuleParser();
        $parsed = [];
        foreach ($rules as $field => $fieldRules) {
            $parsed[$field] = $parser->parseRuleArray($fieldRules);
        }
        return new self($data, $parsed);
    }
    public function validate() : array {
        if($this->fails()) {
            throw new ValidationException($this->errors);
        }
        return array_intersect_key($this->data, $this->rules);
    }
    public function getErrors() : array {
        $this->passes();
        return $this->errors;
    }
    public function passes() : bool {
        if($this->hasRun) {
            return empty( $this->errors );
        }
        $this->hasRun = true;
        foreach ($this->rules as $field => $ruleInstances) {
            $result = $this->data[$field] ?? null;
            foreach( $ruleInstances as $ruleInstance) {
                if(!$ruleInstance->passes($field, $result, $this->data)) {
                    $this->errors[$field][] = $ruleInstance->message($field);
                    break;
                }
            }
        }
        return empty( $this->errors );
    }
    public function fails() : bool {
        return !$this->passes();
    }
}