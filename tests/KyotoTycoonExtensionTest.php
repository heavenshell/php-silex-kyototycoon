<?php
/**
 * Silex KyotoTycoonExtension tests.
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
 * @use       \Silex
 * @category  \Silex
 * @package   \Silex\Extensions
 * @version   $id$
 * @copyright (c) 2011-2012 Shinya Ohyanagi
 * @author    Shinya Ohyanagi <sohyanagi@gmail.com>
 * @license   New BSD License
 */

require_once 'prepare.php';

use Silex\WebTestCase;

/**
 * Zend_Db Test.
 *
 * @use       \Silex
 * @category  \Silex
 * @package   \Silex\Extensions
 * @version   $id$
 * @copyright (c) 2011-2012 Shinya Ohyanagi
 * @author    Shinya Ohyanagi <sohyanagi@gmail.com>
 * @license   New BSD License
 */
class KyotoTycoonExtensionTest extends WebTestCase
{
    private static $_client = null;
    public function createApplication()
    {
        return require dirname(__DIR__) . '/examples/index.php';
    }

    private function _client($uri, $method = 'GET')
    {
        $client = $this->createClient();
        $client->request($method, $uri);
        return $client->getResponse()->getContent();
    }

    public function testShouldSetData()
    {
        $content = $this->_client('/set');
        $this->assertSame(json_decode($content), true);

        $this->assertSame($this->app['kt.client']->get('test'), 'ok');
    }

    public function testShouldGetData()
    {
        $content = $this->_client('/get');
        $this->assertSame(json_decode($content), 'ok');
    }

    public function testShouldRemoveData()
    {
        $content = $this->_client('/remove');
        $this->assertSame(json_decode($content), true);
    }

    public function testShouldReturnFalseWhenRemoveFail()
    {
        $content = $this->_client('/remove/fail');
        $this->assertSame(json_decode($content), false);
    }
}
