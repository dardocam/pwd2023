<?php

class User
{
    private $name;
    private $fechaNacimiento;

    public function __construct(string $name, DateTime $fechaNacimiento)
    {
        $this->name = $name;
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function calcularEdad(): int
    {
        $hoy = new DateTime();
        $intervalo = $hoy->diff($this->fechaNacimiento);
        return $intervalo->format("%y");
    }
    public function __toArray()
    {
        //Define the fields we need
        return array(
            "name" => $this->name,
            "fechaNacimiento" => $this->fechaNacimiento->getTimestamp(),
            "edad" => $this->calcularEdad()
        );
    }
}
