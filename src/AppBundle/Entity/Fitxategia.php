<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Fitxategia
 *
 * @ORM\Table(name="fitxategia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FitxategiaRepository")
 * @Vich\Uploadable
 */
class Fitxategia
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Izenak gutxienez {{ limit }} karaktere izan behar ditu",
     *      maxMessage = "Izenak gehienez {{ limit }} karaktere izan behar ditu"
     * )
     *
     * @ORM\Column(name="izena", type="string", length=255)
     */
    private $izena;

    /**
     * @var string
     * @Assert\Email(
     *     message = "'{{ value }}' ez da baliozko email helbidea.",
     *     checkMX = true
     * )
     *
     * @ORM\Column(name="emaila", type="string", length=255, nullable=true)
     */
    private $emaila;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Kokalekuak gutxienez {{ limit }} karaktere izan behar ditu",
     *      maxMessage = "Kokalekuak gehienez {{ limit }} karaktere izan behar ditu"
     * )
     *
     * @ORM\Column(name="kokalekua", type="string", length=255)
     */
    private $kokalekua;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created",type="datetime")
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $imageSize;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="uploadfile", fileNameProperty="filename", size="imageSize")
     *
     * @var File
     */
    private $uploadfile;

    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * Constructor.
     */
    public function __construct ()
    {
        $this->created = new \DateTime();
    }

    /**
     * Transform (e.g. "Hello World") into a slug (e.g. "hello-world").
     *
     * @param string $string
     *
     * @return string
     */
    public function slugify ( $string )
    {
        $rule           = 'NFD; [:Nonspacing Mark:] Remove; NFC';
        $transliterator = \Transliterator::create( $rule );
        $string         = $transliterator->transliterate( $string );

        return preg_replace(
            '/[^a-z0-9]/',
            '-',
            strtolower( trim( strip_tags( $string ) ) )
        );
    }

    public function getSlug ()
    {
        $filename = $this->izena . "_" . $this->kokalekua . "_" . $this->created->format( 'Y-m-d H:i:s' );

        return $this->slug = $this->slugify( $filename );
    }


    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $uploadfile
     *
     * @return File
     */
    public function setUploadfile(File $uploadfile = null)
    {
        $this->uploadfile = $uploadfile;

        if ($uploadfile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->created = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getUploadfile()
    {
        return $this->uploadfile;
    }

    /**
     * @param string $filename
     *
     * @return File
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename()
    {
        return $this->filename;
    }

    public function __toString ()
    {
        return $this->getSlug();
    }

    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/




    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set izena
     *
     * @param string $izena
     *
     * @return Fitxategia
     */
    public function setIzena($izena)
    {
        $this->izena = $izena;

        return $this;
    }

    /**
     * Get izena
     *
     * @return string
     */
    public function getIzena()
    {
        return $this->izena;
    }

    /**
     * Set emaila
     *
     * @param string $emaila
     *
     * @return Fitxategia
     */
    public function setEmaila($emaila)
    {
        $this->emaila = $emaila;

        return $this;
    }

    /**
     * Get emaila
     *
     * @return string
     */
    public function getEmaila()
    {
        return $this->emaila;
    }

    /**
     * Set kokalekua
     *
     * @param string $kokalekua
     *
     * @return Fitxategia
     */
    public function setKokalekua($kokalekua)
    {
        $this->kokalekua = $kokalekua;

        return $this;
    }

    /**
     * Get kokalekua
     *
     * @return string
     */
    public function getKokalekua()
    {
        return $this->kokalekua;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Fitxategia
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Fitxategia
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set imageSize
     *
     * @param integer $imageSize
     *
     * @return Fitxategia
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    /**
     * Get imageSize
     *
     * @return integer
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }
}
