<?php

namespace Butschster\Tests\Packages;

use Butschster\Head\MetaTags\Meta;
use Butschster\Head\Packages\Script;
use Butschster\Tests\TestCase;

class ScriptTest extends TestCase
{
    function test_it_can_be_created()
    {
        $script = new Script('script_name', 'http://site.com');


        $this->assertEquals(
            '<script src="http://site.com"></script>',
            $script->toHtml()
        );
    }

    function test_it_can_has_attributes()
    {
        $script = new Script('script_name', 'http://site.com', [
            'defer', 'async'
        ]);

        $this->assertEquals(
            '<script src="http://site.com" defer async></script>',
            $script->toHtml()
        );
    }

    function test_in_can_have_dependencies()
    {
        $script = new Script('script_name', 'http://site.com', [], ['jquery', 'vuejs']);

        $this->assertEquals(['jquery', 'vuejs'], $script->getDependencies());

        $script = new Script('script_name', 'http://site.com');
        $this->assertFalse($script->hasDependencies());

        $script->with('jquery');
        $this->assertEquals(['jquery'], $script->getDependencies());

        $script->with(['jquery', 'vue']);
        $this->assertEquals(['jquery', 'vue'], $script->getDependencies());
        $this->assertTrue($script->hasDependencies());
    }

    function test_it_has_footer_default_placement()
    {
        $script = new Script('script_name', 'http://site.com');

        $this->assertEquals(Meta::PLACEMENT_FOOTER, $script->placement());
    }

    function test_a_placement_can_be_set_through_constructor()
    {
        $script = new Script('script_name', 'http://site.com', [], [], 'test');

        $this->assertEquals('test', $script->placement());
    }
}