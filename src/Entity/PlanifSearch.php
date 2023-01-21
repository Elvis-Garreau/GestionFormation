<?php


namespace App\Entity;




class PlanifSearch
{

    /**
     * @var Client|null
     */
    private $client;

    /**
     * @var int|null
     */
    private $periode;

    /**
     * @return Client|null
     */
    public function getClient(): ?Client
    {
        return $this->client;
    }

    /**
     * @param Client|null $client
     * @return PlanifSearch
     */
    public function setClient(?Client $client): PlanifSearch
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPeriode(): ?int
    {
        return $this->periode;
    }

    /**
     * @param int|null $periode
     * @return PlanifSearch
     */
    public function setPeriode(?int $periode): PlanifSearch
    {
        $this->periode = $periode;
        return $this;
    }

}