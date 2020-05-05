<?php
namespace NilPortugues\Tests\Serializer\Drivers\Eloquent;

use Illuminate\Database\Capsule\Manager as Capsule;
use NilPortugues\Serializer\Drivers\Eloquent\EloquentDriver;
use NilPortugues\Tests\Serializer\Drivers\Eloquent\Models\AccountManager;
use NilPortugues\Tests\Serializer\Drivers\Eloquent\Models\User;

/**
 * Class EloquentDriverTest.
 */
class EloquentDriverTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $manager = new AccountManager();
        $manager->username = 'Joe';
        $manager->password = 'password';
        $manager->email = 'joe@example.com';
        $manager->created_at = '2016-01-13 00:06:16';
        $manager->updated_at = '2016-01-13 00:06:16';
        $manager->timestamps = false;
        $manager->save();

        $user = new User();
        $user->account_manager_id = $manager->id;
        $user->username = 'Nil';
        $user->password = 'password';
        $user->email = 'test@example.com';
        $user->created_at = '2016-01-13 00:06:16';
        $user->updated_at = '2016-01-13 00:06:16';
        $user->timestamps = false;
        $user->save();
    }

    public function tearDown()
    {
        Capsule::table('users')->delete();
    }

    public function testSerialize()
    {
        $eloquentDriver = new EloquentDriver();
        $output = $eloquentDriver->serialize(Capsule::table('users')->find(1));

        $expected = array(
            '@type' => 'stdClass',
            'id' => array(
                    '@scalar' => 'string',
                    '@value' => '1',
                ),
            'account_manager_id' => array(
                    '@scalar' => 'string',
                    '@value' => '1',
                ),
            'username' => array(
                    '@scalar' => 'string',
                    '@value' => 'Nil',
                ),
            'password' => array(
                    '@scalar' => 'string',
                    '@value' => 'password',
                ),
            'email' => array(
                    '@scalar' => 'string',
                    '@value' => 'test@example.com',
                ),
            'created_at' => array(
                    '@scalar' => 'string',
                    '@value' => '2016-01-13 00:06:16',
                ),
            'updated_at' => array(
                    '@scalar' => 'string',
                    '@value' => '2016-01-13 00:06:16',
                ),
            'deleted_at' => array(
                    '@scalar' => 'NULL',
                    '@value' => null,
                ),
        );

        $this->assertEquals($expected, $output);
    }
}
