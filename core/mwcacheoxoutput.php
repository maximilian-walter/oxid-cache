<?php

/**
 * Cache-Optimization for OXID eShop
 *
 * @link      https://github.com/maximilian-walter/oxid-cache
 * @copyright Copyright (c) 2014 Maximilian Walter
 * @license   http://opensource.org/licenses/MIT MIT
 */

/**
 * Module for class "oxOutput"
 *
 * @author Maximilian Walter <github@max-walter.net>
 */
class mwCacheOxOutput extends mwCacheOxOutput_parent
{

    /**
     * Configuration for cacheable controllers
     *
     * @var array|null
     */
    protected $_aCacheableControllers = null;

    /**
     * Additional headers
     *
     * @var string[]
     */
    protected $_aAdditionalHeaders = array();

    /**
     * Process our output
     *
     * Checks if the output can be cached
     *
     * @param string $sValue     Output
     * @param string $sClassName Current class
     * @return string
     */
    public function process( $sValue, $sClassName )
    {
        $this->_checkCache( $sClassName );

        return parent::process( $sValue, $sClassName );
    }

    /**
     * Sends http-headers
     *
     * @return void
     */
    public function sendHeaders()
    {
        parent::sendHeaders();

        foreach ( $this->_aAdditionalHeaders as $sHeader ) {
            oxRegistry::getUtils()->setHeader( $sHeader );
        }
    }

    /**
     * Adds additional http-header
     *
     * @param string $sHeader Header
     * @return $this
     */
    public function addHeader( $sHeader )
    {
        $this->_aAdditionalHeaders[] = trim( $sHeader );

        return $this;
    }

    /**
     * Checks if current page should be cached and enables it when needed
     *
     * @param string $sClassName Current class
     */
    protected function _checkCache( $sClassName )
    {
        // Lazy-Load the configuration
        if ( $this->_aCacheableControllers === null ) {
            $this->_loadCacheableControllers();
        }

        // Check if the current class exists in the configuration
        $sClassName = strtolower( $sClassName );
        if ( isset( $this->_aCacheableControllers[$sClassName] ) ) {
            $this->_enableCache( $this->_aCacheableControllers[$sClassName] );
        }
    }

    /**
     * Enables cache for current page
     *
     * @param int $iTtl TTL for the current page
     * @return $this
     */
    protected function _enableCache( $iTtl )
    {
        $time = time() + $iTtl;

        $this
            ->addHeader( 'Date: ' . gmdate( "D, d M Y H:i:s" ) . ' GMT' )
            ->addHeader( 'Last-Modified: ' . gmdate( "D, d M Y H:i:s" ) . ' GMT' )
            ->addHeader( 'Expires: ' . gmdate( "D, d M Y H:i:s", $time ) . ' GMT' )
            ->addHeader( 'Cache-Control: public, max-age=' . ( $time - time() ) );

        // HACK: Make sure the obsolete Pragma-Header is not sent
        header_remove( 'Pragma' );

        return $this;
    }

    /**
     * Loads configuration for cacheable controllers
     *
     * @return void
     */
    protected function _loadCacheableControllers()
    {
        $aConfiguration = (array)$this->getConfig()->getConfigParam( 'aMwCacheCacheableControllers' );

        $this->_aCacheableControllers = array();
        foreach ( $aConfiguration as $sKey => $iValue ) {
            // We need our class-names lowercase and the TTL has to be an integer
            $sKey   = trim( strtolower( $sKey ) );
            $iValue = intval( $iValue );

            // The TTL could be parsed as integer and is not negative, we can use it
            if ( $iValue > 0 ) {
                $this->_aCacheableControllers[$sKey] = $iValue;
            }
        }
    }

}