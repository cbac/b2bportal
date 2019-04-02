<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\LocalisationRepository")
 */
class Localisation
{

    /**
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     *
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evenement", mappedBy="localisation")
     */
    private $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
        $this->calculateLatLon();
        return $this;
    }

    public function __toString(): string
    {
        return $this->getAddress();
    }

    public function calculateLatLon()
    {
        $params = array();
        $options = array();
        $params['q'] = $this->address;
        $params['format'] = "json";
        $params['addressdetails'] = "0";
        $osmURL = "https://nominatim.openstreetmap.org/search";
        // call openstreetmap json interface to calculate latitude and longitude
        $res = $this->curl_get($osmURL, $params, $options);
        $data = json_decode($res);
      //  dump($data);
        if ($data) {
            $this->latitude = 0.0 + $data[0]->lat;
            $this->longitude = 0.0 + $data[0]->lon;
        } else {
            $this->latitude = 0.0 ;
            $this->longitude = 0.0 ;
        }
    }

    /**
     * Send a GET request using cURL
     *
     * @param string $url
     *            to request
     * @param array $get
     *            values to send
     * @param array $options
     *            for cURL
     * @return string
     */
    private function curl_get($url, array $get = NULL, array $options = array())
    {
        $defaults = array(
            CURLOPT_URL => $url . (strpos($url, '?') === FALSE ? '?' : '') . http_build_query($get),
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_USERAGENT => 'curl',
            CURLOPT_REFERER => 'ardoisier.int-evry.fr',
            CURLOPT_TIMEOUT => 4
        );

        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if (! $result = curl_exec($ch)) {
            trigger_error(curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setLocalisation($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->contains($evenement)) {
            $this->evenements->removeElement($evenement);
            // set the owning side to null (unless already changed)
            if ($evenement->getLocalisation() === $this) {
                $evenement->setLocalisation(null);
            }
        }

        return $this;
    }
}
