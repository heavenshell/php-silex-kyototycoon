<?php
/**
 * Silex KyotoTycoon extension.
 *
 * PHP version 5.3
 *
 * Copyright (c) 2011-2012 Shinya Ohyanagi, All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Shinya Ohyanagi nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @use       \Silex\Application
 * @use       \Silex\ServiceProviderInterface
 * @category  \Silex
 * @package   \Silex\Extensions
 * @version   $id$
 * @copyright (c) 2011-2012 Shinya Ohyanagi
 * @author    Shinya Ohyanagi <sohyanagi@gmail.com>
 * @license   New BSD License
 * @see       https://github.com/heavenshell/php-net-kyototycoon
 */

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * KyotoTycoon extension.
 *
 * @use       \Silex\Application
 * @use       \Silex\ServiceProviderInterface
 * @category  \Silex
 * @package   \Silex\Provider
 * @version   $id$
 * @copyright (c) 2011-2012 Shinya Ohyanagi
 * @author    Shinya Ohyanagi <sohyanagi@gmail.com>
 * @license   New BSD License
 * @see       https://github.com/heavenshell/php-net-kyototycoon
 */
class KyotoTycoonExtension implements ServiceProviderInterface
{
    /**
     * Version.
     */
    const VERSION = '0.0.2';

    /**
     * Register extension.
     *
     * @param  Application $app Application
     * @access public
     * @return void
     */
    public function register(Application $app)
    {
        if (isset($app['kt.class_path'])) {
            $app['autoloader']->registerNamespace('Net', $app['kt.class_path']);
            $app['autoloader']->registerNamespace('HTTP', $app['kt.class_path']);
        }
        $app['kt.client'] = $app->share(function () use ($app) {
            $options = isset($app['kt.options']) ? $app['kt.options'] : array();
            $client  = new \Net\KyotoTycoon($options);

            return $client;
        });
    }
}
