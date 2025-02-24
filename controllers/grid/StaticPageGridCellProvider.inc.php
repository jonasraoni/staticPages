<?php

/**
 * @file controllers/grid/StaticPageGridCellProvider.inc.php
 *
 * Copyright (c) 2014-2020 Simon Fraser University
 * Copyright (c) 2000-2020 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class StaticPageGridCellProvider
 * @ingroup controllers_grid_staticPages
 *
 * @brief Class for a cell provider to display information about static pages
 */

use PKP\controllers\grid\GridCellProvider;
use PKP\controllers\grid\GridColumn;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\RedirectAction;
use PKP\controllers\grid\GridHandler;

class StaticPageGridCellProvider extends GridCellProvider
{
    //
    // Template methods from GridCellProvider
    //
    /**
     * Get cell actions associated with this row/column combination
     *
     * @param $row \PKP\controllers\grid\GridRow
     * @param $column GridColumn
     * @param $position int GRID_ACTION_POSITION_...
     *
     * @return array an array of LinkAction instances
     */
    public function getCellActions($request, $row, $column, $position = GridHandler::GRID_ACTION_POSITION_DEFAULT)
    {
        $staticPage = $row->getData();

        switch ($column->getId()) {
            case 'path':
                $dispatcher = $request->getDispatcher();
                return [new LinkAction(
                    'details',
                    new RedirectAction(
                        $dispatcher->url($request, PKPApplication::ROUTE_PAGE, null) . '/' . $staticPage->getPath(),
                        'staticPage'
                    ),
                    htmlspecialchars($staticPage->getPath())
                )];
            default:
                return parent::getCellActions($request, $row, $column, $position);
        }
    }

    /**
     * Extracts variables for a given column from a data element
     * so that they may be assigned to template before rendering.
     *
     * @param $row \PKP\controllers\grid\GridRow
     * @param $column GridColumn
     *
     * @return array
     */
    public function getTemplateVarsFromRowColumn($row, $column)
    {
        $staticPage = $row->getData();

        switch ($column->getId()) {
            case 'path':
                // The action has the label
                return ['label' => ''];
            case 'title':
                return ['label' => $staticPage->getLocalizedTitle()];
        }
    }
}
