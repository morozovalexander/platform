<?php
namespace Oro\Bundle\DataModelBundle\Entity\Mapping;

use Oro\Bundle\DataModelBundle\Model\Entity\AbstractEntityAttribute;
use Oro\Bundle\DataModelBundle\Model\Entity\AbstractEntityAttributeOption;
use Doctrine\ORM\Mapping as ORM;

/**
 * Base Doctrine ORM entity attribute
 *
 * @author    Nicolas Dupont <nicolas@akeneo.com>
 * @copyright 2012 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/MIT  MIT
 *
 */
abstract class AbstractOrmEntityAttribute extends AbstractEntityAttribute
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $code
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    protected $code;

    /**
     * @var string $entityType
     *
     * @ORM\Column(name="entity_type", type="string", length=255)
     */
    protected $entityType;

    /**
     * @var string $backendType
     *
     * @ORM\Column(name="backend_type", type="string", length=255)
     */
    protected $backendType;

    /**
     * @var string $backendModel
     *
     * @ORM\Column(name="backend_model", type="string", length=255)
     */
    protected $backendModel;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(name="is_unique", type="boolean")
     */
    protected $unique;

    /**
     * @ORM\Column(name="is_required", type="boolean")
     */
    protected $required;

    /**
     * @ORM\Column(name="is_searchable", type="boolean")
     */
    protected $searchable;

    /**
     * @ORM\Column(name="is_translatable", type="boolean")
     */
    protected $translatable;

    /**
     * @ORM\Column(name="is_scopable", type="boolean")
     */
    protected $scopable;

    /**
     * @var ArrayCollection $options
     *
     * @ORM\OneToMany(targetEntity="AbstractOrmEntityAttributeOption", mappedBy="attribute", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $options;

    /**
     * Used locale to override Translation listener's locale
     * this is not a mapped attribute of entity metadata, just a simple property
     */
    protected $locale;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->options      = new \Doctrine\Common\Collections\ArrayCollection();
        $this->unique       = false;
        $this->required     = false;
        $this->searchable   = false;
        $this->translatable = false;
        $this->scopable     = false;
    }

    /**
     * Add option
     *
     * @param AbstractEntityAttributeOption $option
     *
     * @return AbstractEntityAttribute
     */
    public function addOption(AbstractEntityAttributeOption $option)
    {
        $this->options[] = $option;
        $option->setAttribute($this);

        return $this;
    }

}
