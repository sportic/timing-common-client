<?php

namespace Sportic\Omniresult\Common\Parsers;

use Sportic\Omniresult\Common\Content\AbstractContent;
use Sportic\Omniresult\Common\Content\ContentFactory;
use Sportic\Omniresult\Common\Content\GenericContent;
use Sportic\Omniresult\Common\Models\AbstractModel;
use Sportic\Omniresult\Common\Parsers\Traits\HasCrawlerTrait;
use Sportic\Omniresult\Common\Parsers\Traits\HasDataTrait;
use Sportic\Omniresult\Common\Parsers\Traits\HasResponseTrait;
use Sportic\Omniresult\Common\Parsers\Traits\HasScraperTrait;
use Sportic\Omniresult\Common\Scrapers\AbstractScraper;
use Sportic\Omniresult\Common\Utility\HasCallValidationTrait;

/**
 * Class AbstractParser
 * @package Sportic\Omniresult\Common\Parsers
 */
abstract class AbstractParser
{
    use HasCallValidationTrait;
    use HasDataTrait;
    use HasCrawlerTrait;
    use HasResponseTrait;
    use HasScraperTrait;

    /**
     * @var null|AbstractContent
     */
    protected $contents = null;

    /**
     * @return mixed
     */
    public function getContent()
    {
        if ($this->contents === null) {
            $this->initContents();
        }

        return $this->contents;
    }

    protected function initContents()
    {
        if ($this->isValidCall()) {
            $this->contents = $this->generateContentObject();
        } else {
            $this->contents = false;
        }
    }

    /**
     * @return AbstractContent
     */
    protected function generateContentObject()
    {
        $contents = $this->generateContent();
        return ContentFactory::createFromArray($contents, $this->getContentClassName());
    }

    abstract protected function generateContent();


    /**
     * @return array
     */
    public function getArray()
    {
        return $this->getContent();
    }

    /**
     * @return AbstractModel
     */
    public function getModel()
    {
        $model = $this->getNewModel();
        $parameters = $this->getContent();
        $model->setParameters($parameters);

        return $model;
    }

    /**
     * @return AbstractModel
     */
    public function getNewModel()
    {
        $className = $this->getModelClassName();
        $model = new $className();

        return $model;
    }

    abstract public function getModelClassName();

    /**
     * @return string
     */
    protected function getContentClassName()
    {
        return GenericContent::class;
    }
}
