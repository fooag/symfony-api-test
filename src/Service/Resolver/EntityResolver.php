<?php

namespace App\Service\Resolver;

use Symfony\Component\OptionsResolver\OptionsResolver;

class EntityResolver extends OptionsResolver
{
    /**
     * check if the parameters is not exist and required
     *
     * @param string $field
     * @param string $type
     * @param bool $isRequired
     * @return $this
     */
    public function configure(string $field, string $type, bool $isRequired): self
    {
        $this->setDefined($field)->setAllowedTypes($field, $type);
        if ($isRequired)
        {
            $this->isRequired($field);
        }

        return $this;
    }
}
