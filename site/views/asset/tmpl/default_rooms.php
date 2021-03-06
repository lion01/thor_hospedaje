<?php
/**
 * @version		$Id: default.php 2013-08-16
 * @copyright	Copyright (C) 2013 Leonardo Alviarez - Edén Arreaza. All Rights Reserved.
 * @license		GNU General Public License version 3, or later
 * @note		Note : All ini files need to be saved as UTF-8 - No BOM
 */

defined('_JEXEC') or die;
$document = JFactory::getDocument();
jimport('thorhospedaje.currency_converter.currency_converter');
$currency = JRequest::getVar('currency');
$exchange_rate=THCurrencyconverter::get_exchange_rate($currency);

?>
	<div class="row-fluid rooms">
		<h3><?php echo JText::_('TH_ASSET_FIELD_ROOMS_LABEL'); ?></h3>
		<hr />
		<?php
		if (isset($this->item->rooms) && ($this->item->rooms)):
		?>
		<div class="row-fluid"><button id="reservation" name="reservation" class="btn btn-primary" style="float: right;" type="submit">
			<i class="icon-checkmark"></i> Reservar	</button></div>
		<?php
			foreach($this->item->rooms as $i => $room):
				($i%2 === 0) ? $class = "even" : $class = "odd";
		?>
		<div class="row-fluid room <?php echo $class; ?>">
			<div class="span4">
				<img src="<?php echo $this->item->image;?>" title="<?php echo $room->asset_name;?>"/>
				<h4><?php echo $room->room_name;?></h4>
				<p><?php echo JText::_('TH_ASSET_FIELD_N_ADULTS_LABEL'); ?>:&nbsp; <?php echo $room->number_adult;?></p>
				<p><?php echo JText::_('TH_ASSET_FIELD_N_CHILDRENS_LABEL'); ?>:&nbsp; <?php echo $room->number_children;?></p>
				<a href="javascript:;" id="more_<?php echo $i;?>"><?php echo JText::_('TH_ASSET_FIELD_VIEW_MORE_LABEL'); ?></a>
			</div>			
			<div class="span5" style="text-align: center; padding-top:2%;">
				<?php 
				if (isset($room->availability_rooms) && $room->availability_rooms):
					
					$script = sprintf("jQuery(document).ready(function($) {\n
										$('#rooms_numbers_%s').chosen({\n
										disable_search_threshold: 10,\n
										allow_single_deselect: true,\n
										});\n
										});",$i);
										
					$document->addScriptDeclaration($script);					
				?>
					<!-- <div class="control-label"><label for="country_id" title=""><?php echo JText::_('Escoja su habitación'); ?></label></div> -->
					<div class="">
					<select multiple="" name="rooms_numbers_<?php echo $i; ?>" id="rooms_numbers_<?php echo $i; ?>" data-no_results_text="<?php echo JText::_('TH_ASSET_FIELD_ROOMS_NUMBERS_NO_RESULTS_TEXT'); ?>" data-placeholder="<?php echo JText::_('TH_ASSEt_FIELD_ROOMS_NUMBERS_PLACEHOLDER'); ?>">
						<option value=""></option>
						<?php
						foreach($room->availability_rooms as $room_number => $availability):
						?>
						<option value="<?php echo $room_number;?>"><?php echo $room_number;?></option>
						<?php
						endforeach;
						?>
					</select>
					</div>
				<?php
				else:
				?>
					<p><?php echo JText::_('TH_ASSET_FIELD_AVAILABILITY_TEXT');?></p>
				<?php
				endif;
				?>
			</div>
			<div class="span3" style="text-align: center; padding-top:2%;">
				<span class="cost"><?php echo THCurrencyconverter::print_cost($room->room_cost, $exchange_rate, $currency);?></span>
			</div>
			<div class="span12 description" id="room_desc_<?php echo $i;?>">
				<?php echo $room->room_desc;?>
			</div>
		</div>
		<?php
			endforeach;
		endif;
		?>
	</div>
	
</div> <!-- mod_th_asset -->
<?php echo $this->pagination->getListFooter(); ?>



