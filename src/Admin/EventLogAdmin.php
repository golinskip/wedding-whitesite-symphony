<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use App\Entity\EventLog;

final class EventLogAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
			->add('date')
			;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
			->add('invitation.name')
			->add('tag', null, ['template' => 'admin/stats/list/tag.html.twig'])
			->add('date')
			->add('userAgent')
			->add('ip')
			->add('_action', null, [
                'actions' => [
                    'show' => [],
                ],
            ]);
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
			->add('invitation.name')
			->add('tag')
			->add('date')
			->add('userAgent')
			->add('ip')
			->add('details', null, ['template' => 'admin/stats/list/details.html.twig'])
			;
	}
	
	public function createQuery($context = 'list')
	{
		$query = parent::createQuery($context);
		$query->andWhere(
			$query->expr()->eq($query->getRootAliases()[0] . '.env', ':env')
		);
		$query->setParameter('env', EventLog::ENV_PRIV);
		return $query;
	}
}
