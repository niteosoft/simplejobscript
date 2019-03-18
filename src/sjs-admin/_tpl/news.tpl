{include file="header.tpl"}
		
<div class="admin-content">
 <div class="admin-wrap-content">

	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb20">
		<label class="admin-label">News</label>
		<div class="alert alert-info fade in main-color">
		    <a href="#" class="close" data-dismiss="alert">&times;</a>
		     <i class="fa fa-info-circle info-fa" aria-hidden="true"></i>&nbsp;
		  	Inform companies about anything. It will be displayed in their dashboard.
		</div>
	</div>

	{if $count > 0}
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	 <table class="table">
	    <thead>
	      <tr>
	        <th>Date</th>
	        <th>Message</th>
	        <th>Delete</th>
	      </tr>
	    </thead>
	    <tbody>
	    	{foreach item=obj key=val from=$news}
	      	<tr>
	       		 <td>{$obj.date_formated}</td>
	       		 <td>{$obj.message}</td>
	       		 <td><a href="{$BASE_URL_ADMIN}news/delete/{$obj.id}" title="Delete this message" onclick="if(!confirm('Are you sure you want to delete this item?'))return false;"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a></td>
	      	</tr>
	      	{/foreach}
	    </tbody>
	  </table>
	  {/if}

	    <br />
	    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-left: 0px; margin-left: 0px;">
			<label>Add new entry</label>
			<form method="post" action="{$BASE_URL_ADMIN}news/add" role="form">
				<div class="form-group">
				  <textarea required class="form-control" rows="5" name="msg" id="msg"></textarea>
				</div>
				<div class="form-group" style="margin-top: 30px;">
				   <button type="submit"  class="btn btn-default btn-primary mbtn" name="submit" id="submit" >Submit</button>
				</div>
			</form>
		</div>

	</div>
  </div>
</div><!-- #content -->

{include file="footer.tpl"}