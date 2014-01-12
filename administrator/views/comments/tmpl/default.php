<?php
/**
 * @version     2.5.x
 * @package     com_improvemycity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the URENIO Research Unit
 */


// no direct access
defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');


$user	= JFactory::getUser();
$userId	= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_improvemycity');
$saveOrder	= $listOrder == 'a.ordering';

$ordering 	= ($listOrder == 'a.id');
$saveOrder 	= ($listOrder == 'a.id' && strtolower($listDirn) == 'asc');
$originalOrders = array();

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_improvemycity&task=comments.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'commentList', 'adminForm', strtolower($listDirn), $saveOrderingUrl, false, true);
}

$sortFields = $this->getSortFields();
?>
<script type="text/javascript">
	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>') {
			dirn = 'asc';
		}
		else {
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>


<form action="<?php echo JRoute::_('index.php?option=com_improvemycity&view=comments'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
		
		<?php
		// Search tools bar
		//echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
		?>
		
	<?php /*	
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('Search'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">
		</div>
	</fieldset>
	 */?>
	
	<?php if (empty($this->items)) : ?>
		<div class="alert alert-no-items">
			<?php echo JText::_('COM_IMPROVEMYCITY_NO_COMMMENTS_YET'); ?>
		</div>
	<?php else : ?>
		
	<table class="table table-striped" id="commentList">
		<thead>
			<tr>
				<th width="1%" class="hidden-phone">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>
						
                
				<th width="10%">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
					<?php if ($canOrder && $saveOrder) :?>
						<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'comments.saveorder'); ?>
					<?php endif; ?>
				</th>
                
                
                <th width="1%" class="nowrap">
                    <?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                </th>
                
                <?php if (isset($this->items[0]->created)) { ?>
                <th width="10%" class="nowrap">
                    <?php echo JHtml::_('grid.sort',  'COM_IMPROVEMYCITY_IMPROVEMYCITY_HEADING_DATE', 'a.created', $listDirn, $listOrder); ?>
                </th>
                <?php } ?>
                
                
                <th width="35%" class="nowrap">
                    <?php echo JHtml::_('grid.sort',  'COM_IMPROVEMYCITY_IMPROVEMYCITY_HEADING_TITLE', 'a.description', $listDirn, $listOrder); ?>
                </th>


				<th width="5%">
					<?php echo JHtml::_('grid.sort',  'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
				</th>


                <th width="30%" class="nowrap">
                    <?php echo JHtml::_('grid.sort',  'COM_IMPROVEMYCITY_IMPROVEMYCITY_HEADING_IMPROVEMYCITYISSUE', 'a.improvemycityid', $listDirn, $listOrder); ?>
                </th>

                <th width="5%" class="nowrap">
                    <?php echo JHtml::_('grid.sort',  'COM_IMPROVEMYCITY_IMPROVEMYCITY_HEADING_IMPROVEMYCITYID', 'a.improvemycityid', $listDirn, $listOrder); ?>
                </th>
                	                

                <th width="30%" class="nowrap">
                    <?php echo JHtml::_('grid.sort',  'COM_IMPROVEMYCITY_IMPROVEMYCITY_HEADING_USERID', 'a.userid', $listDirn, $listOrder); ?>
                </th>
					
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10" class="center">
					<?php echo $this->pagination->getListFooter(); ?>
					<?php echo $this->state->get('params')->get('version'); ?>
				</td>
			</tr>
		</tfoot>
		
		<tbody>
		<?php foreach ($this->items as $i => $item) :
			$ordering	= ($listOrder == 'a.ordering');
			$canCreate	= $user->authorise('core.create',		'com_improvemycity');
			$canEdit	= $user->authorise('core.edit',			'com_improvemycity');
			$canCheckin	= $user->authorise('core.manage',		'com_improvemycity');
			$canChange	= $user->authorise('core.edit.state',	'com_improvemycity');
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>
                <?php if (isset($this->items[0]->ordering)) { ?>
				    <td class="order">
					    <?php if ($canChange) : ?>
						    <?php if ($saveOrder) :?>
							    <?php if ($listDirn == 'asc') : ?>
								    <span><?php echo $this->pagination->orderUpIcon($i, true, 'comments.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
								    <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'items.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
							    <?php elseif ($listDirn == 'desc') : ?>
								    <span><?php echo $this->pagination->orderUpIcon($i, true, 'comments.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
								    <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'comments.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
							    <?php endif; ?>
						    <?php endif; ?>
						    <?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
						    <input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled ?> class="text-area-order" />
					    <?php else : ?>
						    <?php echo $item->ordering; ?>
					    <?php endif; ?>
				    </td>
                <?php } ?>
                <?php if (isset($this->items[0]->id)) { ?>
				<td class="center">
					<?php echo (int) $item->id; ?>
				</td>
                <?php } ?>

                <?php if (isset($this->items[0]->created)) { ?>
				<td class="center">
					<?php echo $item->created; ?>
				</td>
                <?php } ?>

               <?php if (isset($this->items[0]->description)) { ?>
				<td>
					<a href="<?php echo JRoute::_('index.php?option=com_improvemycity&task=comment.edit&id=' . $item->id); ?>">
						<?php echo $item->description; ?>
					</a>		
					<br />
				</td>
                <?php } ?>				
                <?php if (isset($this->items[0]->state)) { ?>
				    <td class="center">
					    <?php echo JHtml::_('jgrid.published', $item->state, $i, 'comments.', $canChange, 'cb'); ?>
				    </td>
                <?php } ?>		
                <?php if (isset($this->items[0]->improvemycityid)) { ?>
				<td>
					<?php echo '<strong>'.$item->issuetitle.'</strong>'; 
					?>
				</td>
                <?php } ?>	                
                <?php if (isset($this->items[0]->improvemycityid)) { ?>
				<td>
					<?php echo '<strong>'.$item->improvemycityid .'</strong>'; 
					?>
				</td>
                <?php } ?>	                
                <?php if (isset($this->items[0]->user)) { ?>
				<td>
					<?php echo '<strong>'.$item->user.'</strong>';?>
				</td>
                <?php } ?>		
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
	
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
