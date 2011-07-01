<?php
/**
 * Phergie
 *
 * PHP version 5
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://phergie.org/license
 *
 * @category  Phergie
 * @package   Phergie_Tests
 * @author    Phergie Development Team <team@phergie.org>
 * @copyright 2008-2011 Phergie Development Team (http://phergie.org)
 * @license   http://phergie.org/license New BSD License
 * @link      http://pear.phergie.org/package/Phergie_Tests
 */

/**
 * Unit test suite for Phergie_Plugin_Message.
 *
 * @category Phergie
 * @package  Phergie_Tests
 * @author   Phergie Development Team <team@phergie.org>
 * @license  http://phergie.org/license New BSD License
 * @link     http://pear.phergie.org/package/Phergie_Tests
 */
class Phergie_Plugin_MessageTest extends Phergie_Plugin_TestCase
{
    /**
     * Initialize a message event.
     *
     * @param string $message Message being sent.
     *
     * @return void
     */
    private function initializeMessageEvent($message)
    {
        $this->plugin->onLoad();
        $args = array(
            'receiver' => $this->source,
            'text' => $message
        );
        $event = $this->getMockEvent('privmsg', $args);
        $this->plugin->setEvent($event);
    }

    public function testGetMessageWithoutAliases()
    {
        $this->initializeMessageEvent($this->connection->getNick() . ', hello');
        $this->assertEquals('hello', $this->plugin->getMessage());
    }

    public function testIsTargetedMessageWithoutAliases()
    {
        $this->initializeMessageEvent($this->connection->getNick() . ', hello');
        $this->assertTrue($this->plugin->isTargetedMessage());
    }

    public function testGetMessageWithAlias()
    {
        $this->setConfig('message.aliases', array('alias'));
        $this->initializeMessageEvent('alias, hello');
        $this->assertEquals('hello', $this->plugin->getMessage());
    }

    public function testIsTargetedMessageWithAlias()
    {
        $this->setConfig('message.aliases', array('alias'));
        $this->initializeMessageEvent('alias, hello');
        $this->assertTrue($this->plugin->isTargetedMessage());
    }
}