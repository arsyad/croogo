<?php

use Cake\Core\Configure;

$this->extend('Croogo/Core./Common/admin_index');

$this->assign('title', __d('croogo', 'Locales'));

$this->Breadcrumbs
    ->add(__d('croogo', 'Extensions'), array('plugin' => 'Croogo/Extensions', 'controller' => 'Plugins', 'action' => 'index'))
    ->add(__d('croogo', 'Locales'), $this->request->getUri()->getPath());

$this->append('action-buttons');
    echo $this->Croogo->adminAction(__d('croogo', 'Upload'),
        array('action' => 'add')
    );
$this->end();

$this->start('table-heading');
    $tableHeaders = $this->Html->tableHeaders(array(
        '',
        __d('croogo', 'Locale'),
        __d('croogo', 'Name'),
        __d('croogo', 'Default'),
        __d('croogo', 'Actions'),
    ));
    echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
    $rows = array();
    $vendorDir = ROOT . DS . 'vendor' . DS . 'croogo' . DS . 'locale' . DS;
    foreach ($locales as $locale => $data):
        $actions = array();

        $actions[] = $this->Croogo->adminRowAction('',
            array('action' => 'activate', $locale),
            array('icon' => $this->Theme->getIcon('power-on'), 'tooltip' => __d('croogo', 'Activate'), 'method' => 'post')
        );
        $actions[] = $this->Croogo->adminRowAction('',
            array('action' => 'edit', $locale),
            array('icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('croogo', 'Edit this item'))
        );

        if (strpos($data['path'], $vendorDir) !== 0):
            $actions[] = $this->Croogo->adminRowAction('',
                ['action' => 'delete', $locale],
                [
                    'icon' => $this->Theme->getIcon('delete'),
                    'tooltip' => __d('croogo', 'Remove this item'),
                ],
                __d('croogo', 'Are you sure?')
            );
        endif;
        $actions = $this->Html->div('item-actions', implode(' ', $actions));
        if ($locale == Configure::read('Site.locale')) {
            $status = $this->Html->status(1);
        } else {
            $status = $this->Html->status(0);
        }

        $rows[] = array(
            '',
            $locale,
            $data['name'],
            $status,
            $actions,
        );
    endforeach;

    echo $this->Html->tableCells($rows);
$this->end();
?>
