<?php
namespace Melody\Validation\ValidationGroups;

use Melody\Validation\Common\Collections\ConstraintsCollection;
use Melody\Validation\Exceptions\InvalidInputException;

class ValidationGroups
{
    /**
     * @var array
     */
    protected $groups = array();

    /**
     * @var array
     */
    protected $violations = array();

    public function add($id, ConstraintsCollection $group)
    {
        $this->groups[$id] = $group;
    }

    public function get($id)
    {
        if (!isset($this->groups[$id])) {
            throw new \InvalidArgumentException("Group $id not found");
        }

        return $this->groups[$id];
    }

    public function remove($id)
    {
        unset($this->groups[$id]);
    }

    public function has($id)
    {
        return isset($this->groups[$id]);
    }

    public function validate($data, $group, $customMessages = array())
    {
        if (!is_array($data)) {
            throw new InvalidInputException('$data argument should be array');
        }
        
        $constraints = $this->get($group);
        $valid = true;
        $this->violations = array();

        foreach ($data as $id => $input) {
            if ($constraints[$id] instanceof \Melody\Validation\Validator && !$constraints[$id]->validate($input)) {
                $valid = false;
                $this->violations = array_merge($this->violations, $constraints[$id]->getViolations($customMessages));
            }
        }

        return $valid;
    }

    public function getViolations()
    {
        return $this->violations;
    }
}
