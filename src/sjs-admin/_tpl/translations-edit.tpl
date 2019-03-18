{include file="header.tpl"}

{literal}
<style>
.table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th,.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th  {
	border: none !important;
}
</style>
{/literal}

	<div class="admin-content">
	<div class="admin-wrap-content">
	 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<label class="admin-label">
			Edit Translations for:&nbsp;&nbsp;
			<select id="translations-lang" class="minput form-control">
				{foreach item=lang from=$languages}
				<option value="{$lang.code}"{if $lang.code == $current_lang} selected="selected"{/if}>{$lang.name}</option>
				{/foreach}
			</select>
		</label>
		<br /><br />
		
		<a href="#" class="new-item" id="new-translation-section-trigger"><i class="fa fa-plus-circle blueColor mr5" aria-hidden="true"></i>&nbsp;Add new section</a>
		
		<div id="new-translation-section"><br />
			<form>
			 		<strong>Name</strong><br />
					<input class="minput form-control" type="text" id="new-section-item" size="17" />
					<div class="mt15">
				 		<button id="add-section-trigger" rel="{$current_lang_id}">Create</button>
						or <a href="#" id="cancel-add-section-trigger">Cancel</a>
					</div>
			</form>
		</div><br /><br />
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="list translations">
				{foreach item=tr_section from=$translations_raw}
					<div class="row {cycle values='even-border, odd'}">
						<div style="float:right;padding:10px"><a href="#" title="Delete this section" class="translation-section-delete" rel="{$tr_section.id}"><i class="ml10 fa fa-trash fa-lg blueColor" aria-hidden="true"></i></a></div>

						<h4 class="genericBig"><span>Section:</span> {$tr_section.section}</h4>
						<a href="#" class="new-item new-translation-trigger"><span title="Add new category" class="mr5 fui-plus-circle blueColor fs13" ></span>&nbsp;Add new item</a>
						
						<div class="new-translation mt15" id="new-translation-{$tr_section.id}">
 							<form>
								<!-- <div class="table-responsive" style="border: none !important;">
									<table class="table">
										<tr><th>Item</th><th>Value</th><th>&nbsp;</th></tr>
										<tr>
											<td><input type="text" class="form-control minput new-translation-item" size="20" /></td>
											<td><input type="text" class="form-control minput new-translation-value" size="40" /></td>
										</tr>
										<tr><td style="padding: 10px;"><button class="new-translation-add-trigger" rel="{$tr_section.id}">Add</button> or <a href="#" class="new-transaction-cancel-trigger">Cancel</a></td></tr>
									</table>
								</div> -->
								<div class="row-fluid">
									<div class="col-lg-3 itemSibling">
										Item <br />
										<input type="text" class="form-control minput new-translation-item" size="20" />
									</div>
									<div class="col-lg-3 valueSibling">
									    Value<br />
										<input type="text" class="form-control minput new-translation-item" size="20" />
									</div>

									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt15">
									<button class="new-translation-add-trigger" rel="{$tr_section.id}">Add</button> or <a href="#" class="new-transaction-cancel-trigger">Cancel</a></div>
								</div>
							</form> 
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt15">
						<div class="table-responsive">
							<table width="100%" id="translations_{$tr_section.id}" class="table">
							{foreach item=tr_item from=$tr_section.items}
								<tr>
									<td valign="top"><strong>{$tr_item.item}:</strong></td>
									<td>
										{if $tr_item.field_type == 'textarea'}
										<textarea style="background-color: #f2f2f2; border: solid 1px #d9d9d9;border-radius: 3px;" cols="70" rows="10" rel="{$tr_item.id}">{$tr_item.value|htmlspecialchars}</textarea>
										{else}
										<input style="background-color: #f2f2f2; border: solid 1px #d9d9d9;border-radius: 3px;" id="item-{$tr_item.id}" type="text" value="{$tr_item.value|htmlspecialchars}" size="70" rel="{$tr_item.id}" />
										{/if}
										 &nbsp;<a href="#" title="Delete this item" class="translation-item-delete" rel="{$tr_item.id}"><i class="ml10 fa fa-trash fa-lg blueColor" aria-hidden="true"></i></a>
									</td>
								</tr>
							{/foreach}
							</table>
						</div>
						</div>
					</div>
				{/foreach}
			</div>
		</div>
		</div>
	</div>
	</div>
		
{include file="footer.tpl"}
