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
/*
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$params = $this->form->getFieldsets('params');
*/

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');

// Create shortcut to parameters.
$params = $this->state->get('params');
$params = $params->toArray();

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'issue.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
			Joomla.submitform(task, document.getElementById('item-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_improvemycity&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	<?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
	
	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('COM_IMPROVEMYCITY_LEGEND_DETAILS', true)); ?>
		<div class="row-fluid">
			<div class="span4">
				<div class="form-vertical">
					<?php foreach($this->form->getFieldset('details') as $field): ?>
						<div class="control-group">
							<?php if (!$field->hidden): ?>
								<?php echo $field->label; ?>
							<?php endif; ?>
							<div class="controls">
								<?php echo $field->input; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="span3">
				<div class="form-vertical">
					<?php foreach($this->form->getFieldset('status') as $field): ?>
						<div class="control-group">
							<?php if (!$field->hidden): ?>
								<?php echo $field->label; ?>
							<?php endif; ?>
							<div class="controls">
								<?php echo $field->input; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="span5">
				<div class="well" style="width: auto;height: 250px;" id="mapCanvas"><?php echo JText::_('COM_IMPROVEMYCITY_IMPROVEMYCITY_MAP');?></div>				
					
					<div id="infoPanel">
					<div style="display:none;" id="info"></div>
					<div style="display:none;"id="near_address"></div>
					<div id="geolocation">
						<input id="address" type="text" size="75" value="">
						<input class="btn btn-primary" type="button" value="<?php echo JText::_('COM_IMPROVEMYCITY_IMPROVEMYCITY_LOCATE');?>" onclick="codeAddress()">
					</div>
						
				</div>	
				<hr />
			</div>
		</div>
		
		<div class="row-fluid">
			<div class="span7">
				<?php if($this->form->getValue('photo') != "") : ?>
				<img src="<?php echo JURI::root().$this->form->getValue('photo'); ?>" class="img-polaroid" />
				<?php endif;?>
			</div>
			<div class="span5">
				<div class="form-horizontal">
					<?php foreach($this->form->getFieldset('geo') as $field): ?>
						<div class="control-group">
							<?php if (!$field->hidden): ?>
								<div class="control-label">
								<?php echo $field->label; ?>
								</div>
							<?php endif; ?>
							<div class="controls">
								<?php echo $field->input; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>								
			
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>	
		
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'user', JText::_('COM_IMPROVEMYCITY_LEGEND_USER_DETAILS', true)); ?>
			<address>
			<strong><?php echo $this->issuer->name; ?></strong><br />
			<?php echo $this->issuer->username; ?><br />
			<a href="mailto:<?php echo $this->issuer->email; ?>"><?php echo $this->issuer->email; ?></a>
			</address>			
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'comments', JText::_('COM_IMPROVEMYCITY_TITLE_COMMENTS', true)); ?>
			<div class="alert alert-info"><strong>TODO:</strong> Comments concerning the specific issue will appear at this tab</div>		
		<?php echo JHtml::_('bootstrap.endTab'); ?>				
	</div>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>

</form>
