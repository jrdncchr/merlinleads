<?php
/**
 * This file is part of PHPPresentation - A pure PHP library for reading and writing
 * presentations documents.
 *
 * PHPPresentation is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPPresentation/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPPresentation
 * @copyright   2009-2015 PHPPresentation contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpPresentation\Writer;

use DirectoryIterator;
use PhpOffice\Common\Adapter\Zip\ZipArchiveAdapter;
use PhpOffice\PhpPresentation\HashTable;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\Shape\AbstractDrawing;
use PhpOffice\PhpPresentation\Shape\Chart as ChartShape;
use PhpOffice\PhpPresentation\Shape\Group;
use PhpOffice\PhpPresentation\Shape\Table;
use PhpOffice\PhpPresentation\Writer\PowerPoint2007\LayoutPack\AbstractLayoutPack;
use PhpOffice\PhpPresentation\Writer\PowerPoint2007\LayoutPack\PackDefault;

/**
 * \PhpOffice\PhpPresentation\Writer\PowerPoint2007
 */
class PowerPoint2007 extends AbstractWriter implements WriterInterface
{
    /**
     * Private PhpPresentation
     *
     * @var \PhpOffice\PhpPresentation\PhpPresentation
     */
    protected $presentation;

    /**
     * Private unique hash table
     *
     * @var \PhpOffice\PhpPresentation\HashTable
     */
    protected $drawingHashTable;

    /**
     * Use disk caching where possible?
     *
     * @var boolean
     */
    protected $useDiskCaching = false;

    /**
     * Disk caching directory
     *
     * @var string
     */
    protected $diskCachingDir;

    /**
     * Layout pack to use
     *
     * @var \PhpOffice\PhpPresentation\Writer\PowerPoint2007\LayoutPack\AbstractLayoutPack
     */
    protected $layoutPack;

    /**
     * Create a new PowerPoint2007 file
     *
     * @param PhpPresentation $pPhpPresentation
     */
    public function __construct(PhpPresentation $pPhpPresentation = null)
    {
        // Assign PhpPresentation
        $this->setPhpPresentation($pPhpPresentation);

        // Set up disk caching location
        $this->diskCachingDir = './';

        // Set layout pack
        $this->layoutPack = new PackDefault();

        // Set HashTable variables
        $this->drawingHashTable = new HashTable();

        $this->setZipAdapter(new ZipArchiveAdapter());
    }

    /**
     * Save PhpPresentation to file
     *
     * @param  string    $pFilename
     * @throws \Exception
     */
    public function save($pFilename)
    {
        if (empty($pFilename)) {
            throw new \Exception("Filename is empty");
        }
        if (empty($this->presentation)) {
            throw new \Exception("PhpPresentation object unassigned");
        }
        // If $pFilename is php://output or php://stdout, make it a temporary file...
        $originalFilename = $pFilename;
        if (strtolower($pFilename) == 'php://output' || strtolower($pFilename) == 'php://stdout') {
            $pFilename = @tempnam('./', 'phppttmp');
            if ($pFilename == '') {
                $pFilename = $originalFilename;
            }
        }

        // Create drawing dictionary
        $this->drawingHashTable->addFromSource($this->allDrawings());

        $oZip = $this->getZipAdapter();
        $oZip->open($pFilename);

        $oDir = new DirectoryIterator(dirname(__FILE__).DIRECTORY_SEPARATOR.'PowerPoint2007');
        foreach ($oDir as $oFile) {
            if (!$oFile->isFile()) {
                continue;
            }
            $class = __NAMESPACE__.'\\PowerPoint2007\\'.$oFile->getBasename('.php');
            $o = new \ReflectionClass($class);

            if ($o->isAbstract() || !$o->isSubclassOf('PhpOffice\PhpPresentation\Writer\PowerPoint2007\AbstractDecoratorWriter')) {
                continue;
            }
            $oService = $o->newInstance();
            $oService->setZip($oZip);
            $oService->setPresentation($this->presentation);
            $oService->setDrawingHashTable($this->drawingHashTable);
            $oZip = $oService->render();
            unset($oService);
        }

        // Close file
        $oZip->close();

        // If a temporary file was used, copy it to the correct file stream
        if ($originalFilename != $pFilename) {
            if (copy($pFilename, $originalFilename) === false) {
                throw new \Exception("Could not copy temporary zip file $pFilename to $originalFilename.");
            }
            if (@unlink($pFilename) === false) {
                throw new \Exception('The file '.$pFilename.' could not be removed.');
            }
        }
    }

    /**
     * Get PhpPresentation object
     *
     * @return PhpPresentation
     * @throws \Exception
     */
    public function getPhpPresentation()
    {
        if (empty($this->presentation)) {
            throw new \Exception("No PhpPresentation assigned.");
        }
        return $this->presentation;
    }

    /**
     * Set PhpPresentation object
     *
     * @param  PhpPresentation $pPhpPresentation PhpPresentation object
     * @throws \Exception
     * @return \PhpOffice\PhpPresentation\Writer\PowerPoint2007
     */
    public function setPhpPresentation(PhpPresentation $pPhpPresentation = null)
    {
        $this->presentation = $pPhpPresentation;
        return $this;
    }

    /**
     * Get use disk caching where possible?
     *
     * @return boolean
     */
    public function hasDiskCaching()
    {
        return $this->useDiskCaching;
    }

    /**
     * Set use disk caching where possible?
     *
     * @param  boolean $pValue
     * @param  string $pDirectory Disk caching directory
     * @throws \Exception
     * @return \PhpOffice\PhpPresentation\Writer\PowerPoint2007
     */
    public function setUseDiskCaching($pValue = false, $pDirectory = null)
    {
        $this->useDiskCaching = $pValue;

        if (!is_null($pDirectory)) {
            if (is_dir($pDirectory)) {
                $this->diskCachingDir = $pDirectory;
            } else {
                throw new \Exception("Directory does not exist: $pDirectory");
            }
        }

        return $this;
    }

    /**
     * Get disk caching directory
     *
     * @return string
     */
    public function getDiskCachingDirectory()
    {
        return $this->diskCachingDir;
    }

    /**
     * Get layout pack to use
     *
     * @return \PhpOffice\PhpPresentation\Writer\PowerPoint2007\LayoutPack\AbstractLayoutPack
     */
    public function getLayoutPack()
    {
        return $this->layoutPack;
    }

    /**
     * Set layout pack to use
     *
     * @param \PhpOffice\PhpPresentation\Writer\PowerPoint2007\LayoutPack\AbstractLayoutPack $pValue
     * @return \PhpOffice\PhpPresentation\Writer\PowerPoint2007
     */
    public function setLayoutPack(AbstractLayoutPack $pValue = null)
    {
        $this->layoutPack = $pValue;

        return $this;
    }

    /**
     * Get an array of all drawings
     *
     * @return \PhpOffice\PhpPresentation\Shape\AbstractDrawing[] All drawings in PhpPresentation
     * @throws \Exception
     */
    protected function allDrawings()
    {
        // Get an array of all drawings
        $aDrawings  = array();

        // Loop trough PhpPresentation
        foreach ($this->getPhpPresentation()->getAllSlides() as $oSlide) {
            $oCollection = $oSlide->getShapeCollection();
            if ($oCollection->count() <= 0) {
                continue;
            }
            $oIterator = $oCollection->getIterator();
            while ($oIterator->valid()) {
                if ($oIterator->current() instanceof AbstractDrawing && !($oIterator->current() instanceof Table)) {
                    $aDrawings[] = $oIterator->current();
                } elseif ($oIterator->current() instanceof Group) {
                    $oSubIterator = $oIterator->current()->getShapeCollection()->getIterator();
                    while ($oSubIterator->valid()) {
                        if ($oSubIterator->current() instanceof AbstractDrawing && !($oSubIterator->current() instanceof Table)) {
                            $aDrawings[] = $oSubIterator->current();
                        }
                        $oSubIterator->next();
                    }
                }

                $oIterator->next();
            }
        }

        return $aDrawings;
    }
}
