<!-- !!! Add form action below -->
<form role="form" action="{{ route('logoinc.bread.relationship') }}" method="POST">
	<div class="modal fade modal-danger modal-relationships" id="new_relationship_modal">
		<div class="modal-dialog relationship-panel">
		    <div class="model-content">
		        <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"
	                        aria-hidden="true">&times;</button>
	                <h4 class="modal-title"><i class="logoinc-heart"></i> {{ \Illuminate\Support\Str::singular(ucfirst($table)) }}
					{{ __('logoinc::database.relationship.relationships') }} </h4>
	            </div>

		        <div class="modal-body">
			        <div class="row">

			        	@if(isset($dataType->id))
				            <div class="col-md-12 relationship_details">
				                <p class="relationship_table_select">{{ \Illuminate\Support\Str::singular(ucfirst($table)) }}</p>
				                <select class="relationship_type select2" name="relationship_type">
				                    <option value="hasOne" @if(isset($relationshipDetails->type) && $relationshipDetails->type == 'hasOne') selected="selected" @endif>{{ __('logoinc::database.relationship.has_one') }}</option>
				                    <option value="hasMany" @if(isset($relationshipDetails->type) && $relationshipDetails->type == 'hasMany') selected="selected" @endif>{{ __('logoinc::database.relationship.has_many') }}</option>
				                    <option value="belongsTo" @if(isset($relationshipDetails->type) && $relationshipDetails->type == 'belongsTo') selected="selected" @endif>{{ __('logoinc::database.relationship.belongs_to') }}</option>
				                    <option value="belongsToMany" @if(isset($relationshipDetails->type) && $relationshipDetails->type == 'belongsToMany') selected="selected" @endif>{{ __('logoinc::database.relationship.belongs_to_many') }}</option>
				                </select>
				                <select class="relationship_table select2" name="relationship_table">
				                    @foreach($tables as $tbl)
				                        <option value="{{ $tbl }}" @if(isset($relationshipDetails->table) && $relationshipDetails->table == $tbl) selected="selected" @endif>{{ \Illuminate\Support\Str::singular(ucfirst($tbl)) }}</option>
				                    @endforeach
				                </select>
				                <span><input type="text" class="form-control" name="relationship_model" placeholder="{{ __('logoinc::database.relationship.namespace') }}" value="{{ $relationshipDetails->model ?? ''}}"></span>
				            </div>
				            <div class="col-md-12 relationship_details relationshipField">
				            	<div class="belongsTo">
				            		<label>{{ __('logoinc::database.relationship.which_column_from') }} <span>{{ \Illuminate\Support\Str::singular(ucfirst($table)) }}</span> {{ __('logoinc::database.relationship.is_used_to_reference') }} <span class="label_table_name"></span>?</label>
				            		<select name="relationship_column_belongs_to" class="new_relationship_field select2">
				                    	@foreach($fieldOptions as $data)
				                        	<option value="{{ $data['field'] }}">{{ $data['field'] }}</option>
				                    	@endforeach
				               		</select>
				               	</div>
				               	<div class="hasOneMany flexed">
				            		<label>{{ __('logoinc::database.relationship.which_column_from') }} <span class="label_table_name"></span> {{ __('logoinc::database.relationship.is_used_to_reference') }} <span>{{ \Illuminate\Support\Str::singular(ucfirst($table)) }}</span>?</label>
					                <select name="relationship_column" class="new_relationship_field select2 rowDrop" data-table="{{ $tables[0] }}" data-selected="">
					                </select>
					            </div>
				            </div>
				            <div class="col-md-12 relationship_details relationshipPivot">
				            	<label>{{ __('logoinc::database.relationship.pivot_table') }}:</label>
				            	<select name="relationship_pivot" class="select2">
		                        	@foreach($tables as $tbl)
				                        <option value="{{ $tbl }}" @if(isset($relationshipDetails->table) && $relationshipDetails->table == $tbl) selected="selected" @endif>{{ \Illuminate\Support\Str::singular(ucfirst($tbl)) }}</option>
				                    @endforeach
		                        </select>
				            </div>
				            <div class="col-md-12 relationship_details_more">
				                <div class="well">
				                    <label>{{ __('logoinc::database.relationship.selection_details') }}</label>
				                    <p><strong>{{ __('logoinc::database.relationship.display_the') }} <span class="label_table_name"></span>: </strong>
				                        <select name="relationship_label" class="rowDrop select2" data-table="{{ $tables[0] }}" data-selected="">
				                        </select>
				                    </p>
				                    <p class="relationship_key"><strong>{{ __('logoinc::database.relationship.store_the') }} <span class="label_table_name"></span>: </strong>
				                        <select name="relationship_key" class="rowDrop select2" data-table="{{ $tables[0] }}" data-selected="">
				                        </select>
									</p>

									<p class="relationship_taggable"><strong>{{ __('logoinc::database.relationship.allow_tagging') }}:</strong> <br>
										<input type="checkbox" name="relationship_taggable" class="toggleswitch" data-on="{{ __('logoinc::generic.yes') }}" data-off="{{ __('logoinc::generic.no') }}">
				                    </p>
				                </div>
							</div>
				        @else
				        	<div class="col-md-12">
				        		<h5><i class="logoinc-rum-1"></i> {{ __('logoinc::database.relationship.easy_there') }}</h5>
				        		<p class="relationship-warn">{!! __('logoinc::database.relationship.before_create') !!}</p>
				        	</div>
				        @endif

			        </div>
			    </div>
			    <div class="modal-footer">
			    	<div class="relationship-btn-container">
			    		<button type="button" class="btn btn-default" data-dismiss="modal">{{ __('logoinc::database.relationship.cancel') }}</button>
	                    @if(isset($dataType->id))
	                    	<button class="btn btn-danger btn-relationship"><i class="logoinc-plus"></i> <span>{{ __('logoinc::database.relationship.add_new') }}</span></button>
	                	@endif
	                </div>
			    </div>
		    </div>
		</div>
	</div>
	<input type="hidden" value="{{ $dataType->id ?? '' }}" name="data_type_id">
	{{ csrf_field() }}
</form>
