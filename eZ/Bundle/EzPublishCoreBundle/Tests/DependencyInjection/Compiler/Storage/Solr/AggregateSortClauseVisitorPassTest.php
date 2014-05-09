<?php
/**
 * File containing the AggregateSortClauseVisitorPassTest class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Bundle\EzPublishCoreBundle\Tests\DependencyInjection\Compiler\Storage\Solr;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Compiler\Storage\Solr\AggregateSortClauseVisitorPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTest;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class AggregateSortClauseVisitorPassTest extends AbstractCompilerPassTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->setDefinition(
            'ezpublish.persistence.solr.search.content.sort_clause_visitor.aggregate',
            new Definition()
        );
    }

    /**
     * Register the compiler pass under test, just like you would do inside a bundle's load()
     * method:
     *
     *   $container->addCompilerPass(new MyCompilerPass());
     */
    protected function registerCompilerPass( ContainerBuilder $container )
    {
        $container->addCompilerPass( new AggregateSortClauseVisitorPass() );
    }

    public function testAddVisitor()
    {
        $serviceId = 'service_id';
        $def = new Definition();
        $def->addTag( 'ezpublish.persistence.solr.search.content.sort_clause_visitor' );
        $this->setDefinition( $serviceId, $def );

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'ezpublish.persistence.solr.search.content.sort_clause_visitor.aggregate',
            'addVisitor',
            array( new Reference( $serviceId ) )
        );
    }
}
