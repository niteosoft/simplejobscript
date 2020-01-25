{include file="header.tpl"}
		
		<div class="admin-content">
		  <div class="admin-wrap-content">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb20">
			  <label class="admin-label">Statistics</label>
			  <div>{if not $PAYPAL_PLUGIN} Note: Paypal payment plugin missing.{/if}</div>
			</div>
			<br /><br />

			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				
				{if $PAYPAL_PLUGIN == '1'}
				<div class="row-fluid">
					<div class="light">Payments / orders</div>
						<div class="row dash-boxes">
							<div class="dash-box1">
								<div class="row dash-icon" style="margin: 0; padding: 0;">{$payment_reports['this_week']}</div>
								<div class="row dash-text" >payments this week</div>
							</div>
							<div class="dash-box2">
								<div class="row dash-icon" style="margin: 0; padding: 0;">{$payment_reports['this_month']}</div>
								<div class="row dash-text" >payments this month</div>
							</div>
							<div class="dash-box3">
								<div class="row dash-icon" style="margin: 0; padding: 0;">{$payment_reports['monthly_revenue']}</div>
								<div class="row dash-text" >last 30 days revenue</div>
							</div>
						</div>
				</div>
				{else}
				<div class="row-fluid">
					<div class="light">Payments / orders</div>
						<div class="row dash-boxes">
							<div class="dash-box1">
								<div class="row dash-icon" style="margin: 0; padding: 0;">*</div>
								<div class="row dash-text" >payments this week</div>
							</div>
							<div class="dash-box2">
								<div class="row dash-icon" style="margin: 0; padding: 0;">*</div>
								<div class="row dash-text" >payments this month</div>
							</div>
							<div class="dash-box3">
								<div class="row dash-icon" style="margin: 0; padding: 0;">*</div>
								<div class="row dash-text" >last 30 days revenue</div>
							</div>
						</div>
				</div>
				{/if}

				<br />
				<div class="row-fluid">
					<div class="light">New application statistics</div>
						<div class="row dash-boxes">
							<div class="dash-box1">
								<div class="row dash-icon" style="margin: 0; padding: 0;">{$app_stats['today']}</div>
								<div class="row dash-text" >applications today</div>
							</div>
							<div class="dash-box2">
								<div class="row dash-icon" style="margin: 0; padding: 0;">{$app_stats['this_week']}</div>
								<div class="row dash-text" >applications this week</div>
							</div>
							<div class="dash-box3">
								<div class="row dash-icon" style="margin: 0; padding: 0;">{$app_stats['this_month']}</div>
								<div class="row dash-text" >applications this month</div>
							</div>
						</div>
				</div>
				<br />
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				
				<div class="row-fluid">
					<div class="light">New jobs statistics</div>

					<div class="row dash-boxes">
						<div class="dash-box1">
							<div class="row dash-icon" style="margin: 0; padding: 0;">{$job_stats['today']} </div>
							<div class="row dash-text" >new jobs today</div>
						</div>
						<div class="dash-box2">
							<div class="row dash-icon" style="margin: 0; padding: 0;">{$job_stats['this_week']}</div>
							<div class="row dash-text" >new jobs this week</div>
						</div>
						<div class="dash-box3">
							<div class="row dash-icon" style="margin: 0; padding: 0;">{$job_stats['this_month']}</div>
							<div class="row dash-text" >new jobs this month</div>
						</div>
					</div>
				</div>
				<br />


				<div class="row-fluid">
					<div class="light">Job board users</div>

					<div class="row dash-boxes">
						<div class="dash-box1">
							<div class="row dash-icon" style="margin: 0; padding: 0;">{$user_stats['companies']} </div>
							<div class="row dash-text" >registered companies</div>
						</div>
						<div class="dash-box2">
							<div class="row dash-icon" style="margin: 0; padding: 0;">{$user_stats['candidates']}</div>
							<div class="row dash-text" >registered candidates</div>
						</div>
						<div class="dash-box3">
							<div class="row dash-icon" style="margin: 0; padding: 0;">{$user_stats['subscribers']}</div>
							<div class="row dash-text" >total subscribers</div>
						</div>
					</div>
				</div>
				<br />
			</div>
			<br /><br />
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<br />
				<div class="row-fluid">
					<div class="light mb20">Spam report</div>

					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr class="fs14">
									<th>Job title</th>
									<th>Message</th>
									<th>Votes</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody class="gray">
							{section name=tmp loop=$spam_reports}
								<tr>
									<td>{$spam_reports[tmp].title}</td>
									<td>{$spam_reports[tmp].msg}</td>
									<td>{$spam_reports[tmp].count}</td>
									<td>{$spam_reports[tmp].date}</td>
								</tr>
							{/section}
						</table>
					</div>
				</div>

				<br /><br />
	 		<!-- LAST 50 SEARCHES -->
				<div class="row-fluid">
					<label class="light" >{$translations.stats.last_50_searches}</label>
					<div class="">
						<div class="suggestion mb1">
							<span class="blue-font">Total searches:</span> {$keywordz.count},&nbsp; <span class="blue-font">Average last week:</span> {$keywordz.avg},&nbsp;  <span class="blue-font">Maximum last week:</span> {$keywordz.max}
						</div><br />
						<div class="stats_list">{$keywordz.stats}</div>
					</div>
				</div>
			</div>
		</div>

{include file="footer.tpl"}