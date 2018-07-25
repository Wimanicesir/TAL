<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017
 */

$selected = function( $key, $code ) {
	return ( $key == $code ? 'selected="selected"' : '' );
};


$enc = $this->encoder();
$params = $this->get( 'pageParams', [] );

$newTarget = $this->config( 'admin/jqadm/url/create/target' );
$newCntl = $this->config( 'admin/jqadm/url/create/controller', 'Jqadm' );
$newAction = $this->config( 'admin/jqadm/url/create/action', 'create' );
$newConfig = $this->config( 'admin/jqadm/url/create/config', [] );

$getTarget = $this->config( 'admin/jqadm/url/get/target' );
$getCntl = $this->config( 'admin/jqadm/url/get/controller', 'Jqadm' );
$getAction = $this->config( 'admin/jqadm/url/get/action', 'get' );
$getConfig = $this->config( 'admin/jqadm/url/get/config', [] );

$delTarget = $this->config( 'admin/jsonadm/url/target' );
$delCntl = $this->config( 'admin/jsonadm/url/controller', 'Jsonadm' );
$delAction = $this->config( 'admin/jsonadm/url/action', 'delete' );
$delConfig = $this->config( 'admin/jsonadm/url/config', [] );


/** admin/jqadm/customer/product/fields
 * List of list and product columns that should be displayed in the customer product view
 *
 * Changes the list of list and product columns shown by default in the customer product view.
 * The columns can be changed by the editor as required within the administraiton
 * interface.
 *
 * The names of the colums are in fact the search keys defined by the managers,
 * e.g. "customer.lists.status" for the status value.
 *
 * @param array List of field names, i.e. search keys
 * @since 2017.07
 * @category Developer
 */
$default = ['customer.lists.position', 'customer.lists.status', 'customer.lists.typeid', 'customer.lists.config', 'customer.lists.refid'];
$default = $this->config( 'admin/jqadm/customer/product/fields', $default );
$fields = $this->session( 'aimeos/admin/jqadm/customerproduct/fields', $default );

$listItems = $this->get( 'productListItems', [] );
$refItems = $this->get( 'productItems', [] );


?>
<div id="product" class="item-product content-block tab-pane fade" role="tabpanel" aria-labelledby="product">

	<?= $this->partial(
			$this->config( 'admin/jqadm/partial/pagination', 'common/partials/pagination-standard.php' ),
			['pageParams' => $params, 'pos' => 'top', 'total' => $this->get( 'productTotal' ),
			'group' => 'up', 'action' => 'get', 'fragment' => 'product',
			'page' => $this->session( 'aimeos/admin/jqadm/customerproduct/page', [] )]
		);
	?>

	<table class="list-items table table-striped table-hover">
		<thead class="list-header">
			<tr>
				<?= $this->partial(
					$this->config( 'admin/jqadm/partial/listhead', 'common/partials/listhead-standard.php' ), [
						'fields' => $fields, 'params' => $params, 'tabindex' => $this->get( 'tabindex' ),
						'group' => 'up', 'action' => 'get', 'fragment' => 'product',
						'sort' => $this->session( 'aimeos/admin/jqadm/customerproduct/sort' ),
						'data' => [
							'customer.lists.position' => $this->translate( 'admin', 'Position' ),
							'customer.lists.status' => $this->translate( 'admin', 'Status' ),
							'customer.lists.typeid' => $this->translate( 'admin', 'Type' ),
							'customer.lists.config' => $this->translate( 'admin', 'Config' ),
							'customer.lists.datestart' => $this->translate( 'admin', 'Start date' ),
							'customer.lists.dateend' => $this->translate( 'admin', 'End date' ),
							'customer.lists.refid' => $this->translate( 'admin', 'Product ID' ),
						]
					] );
				?>

				<th class="actions">
					<a class="btn fa act-add" href="#" tabindex="<?= $this->get( 'tabindex' ); ?>"
						title="<?= $enc->attr( $this->translate( 'admin', 'Insert new entry (Ctrl+I)') ); ?>"
						aria-label="<?= $enc->attr( $this->translate( 'admin', 'Add' ) ); ?>">
					</a>

					<?= $this->partial(
						$this->config( 'admin/jqadm/partial/columns', 'common/partials/columns-standard.php' ), [
							'fields' => $fields, 'group' => 'up', 'tabindex' => $this->get( 'tabindex' ),
							'data' => [
								'customer.lists.position' => $this->translate( 'admin', 'Position' ),
								'customer.lists.status' => $this->translate( 'admin', 'Status' ),
								'customer.lists.typeid' => $this->translate( 'admin', 'Type' ),
								'customer.lists.config' => $this->translate( 'admin', 'Config' ),
								'customer.lists.datestart' => $this->translate( 'admin', 'Start date' ),
								'customer.lists.dateend' => $this->translate( 'admin', 'End date' ),
								'customer.lists.refid' => $this->translate( 'admin', 'Product' ),
							]
						] );
					?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?= $this->partial(
				$this->config( 'admin/jqadm/partial/listsearch', 'common/partials/listsearch-standard.php' ), [
					'filter' => $this->session( 'aimeos/admin/jqadm/customerproduct/filter', [] ),
					'fields' => $fields, 'group' => 'up', 'tabindex' => $this->get( 'tabindex' ),
					'data' => [
						'customer.lists.position' => ['op' => '>=', 'type' => 'number'],
						'customer.lists.status' => ['op' => '==', 'type' => 'select', 'val' => [
							'1' => $this->translate( 'mshop/code', 'status:1' ),
							'0' => $this->translate( 'mshop/code', 'status:0' ),
							'-1' => $this->translate( 'mshop/code', 'status:-1' ),
							'-2' => $this->translate( 'mshop/code', 'status:-2' ),
						]],
						'customer.lists.typeid' => ['op' => '==', 'type' => 'select', 'val' => $this->get( 'productListTypes', [])],
						'customer.lists.config' => ['op' => '~='],
						'customer.lists.datestart' => ['op' => '>=', 'type' => 'datetime-local'],
						'customer.lists.dateend' => ['op' => '>=', 'type' => 'datetime-local'],
						'customer.lists.refid' => ['op' => '=='],
					]
				] );
			?>

			<tr class="list-item-new prototype">
				<td colspan="<?= count( $fields ); ?>">
					<div class="content-block row">
						<div class="col-xl-6">
							<div class="form-group row mandatory">
								<label class="col-sm-4 form-control-label"><?= $enc->html( $this->translate( 'admin', 'Product' ) ); ?></label>
								<div class="col-sm-8">
									<input class="item-listid" type="hidden" disabled="disabled"
										name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.id', '' ) ) ); ?>" />
									<input class="item-config" type="hidden" disabled="disabled"
										name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.config', '' ) ) ); ?>" />
									<input class="item-label" type="hidden" disabled="disabled"
										name="<?= $enc->attr( $this->formparam( array( 'product', 'product.label', '' ) ) ); ?>" />
									<select class="combobox-prototype item-refid" tabindex="<?= $this->get( 'tabindex' ); ?>" disabled="disabled"
										name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.refid', '' ) ) ); ?>">
									</select>
								</div>
							</div>
							<div class="form-group row mandatory">
								<label class="col-sm-4 form-control-label"><?= $enc->html( $this->translate( 'admin', 'Status' ) ); ?></label>
								<div class="col-sm-8">
									<select class="form-control custom-select item-status" required="required" tabindex="<?= $this->get( 'tabindex' ); ?>" disabled="disabled"
										name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.status', '' ) ) ); ?>">
										<option value="">
											<?= $enc->html( $this->translate( 'admin', 'Please select' ) ); ?>
										</option>
										<option value="1">
											<?= $enc->html( $this->translate( 'mshop/code', 'status:1' ) ); ?>
										</option>
										<option value="0">
											<?= $enc->html( $this->translate( 'mshop/code', 'status:0' ) ); ?>
										</option>
										<option value="-1">
											<?= $enc->html( $this->translate( 'mshop/code', 'status:-1' ) ); ?>
										</option>
										<option value="-2">
											<?= $enc->html( $this->translate( 'mshop/code', 'status:-2' ) ); ?>
										</option>
									</select>
								</div>
							</div>
							<div class="form-group row mandatory">
								<label class="col-sm-4 form-control-label"><?= $enc->html( $this->translate( 'admin', 'Type' ) ); ?></label>
								<div class="col-sm-8">
									<select class="form-control custom-select item-typeid" required="required" tabindex="<?= $this->get( 'tabindex' ); ?>" disabled="disabled"
										name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.typeid', '' ) ) ); ?>" >
										<option value="">
											<?= $enc->html( $this->translate( 'admin', 'Please select' ) ); ?>
										</option>

										<?php foreach( $this->get( 'productListTypes', [] ) as $id => $type ) : ?>
											<option value="<?= $enc->attr( $id ); ?>"><?= $enc->html( $type ); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row optional">
								<label class="col-sm-4 form-control-label"><?= $enc->html( $this->translate( 'admin', 'Start date' ) ); ?></label>
								<div class="col-sm-8">
									<input class="form-control item-datestart" type="datetime-local" tabindex="<?= $this->get( 'tabindex' ); ?>"
										name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.datestart', '' ) ) ); ?>" disabled="disabled" />
								</div>
							</div>
							<div class="form-group row optional">
								<label class="col-sm-4 form-control-label"><?= $enc->html( $this->translate( 'admin', 'End date' ) ); ?></label>
								<div class="col-sm-8">
									<input class="form-control item-dateend" type="datetime-local" tabindex="<?= $this->get( 'tabindex' ); ?>"
										name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.dateend', '' ) ) ); ?>" disabled="disabled" />
								</div>
							</div>
							<div class="form-group row optional">
								<label class="col-sm-4 form-control-label"><?= $enc->html( $this->translate( 'admin', 'Position' ) ); ?></label>
								<div class="col-sm-8">
									<input class="form-control item-position" type="number" step="1" tabindex="<?= $this->get( 'tabindex' ); ?>"
										name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.position', '' ) ) ); ?>" disabled="disabled" />
								</div>
							</div>
						</div>
						<div class="col-xl-6">
							<table class="item-config config-multiple table table-striped">
								<thead>
									<tr>
										<th>
											<span class="help"><?= $enc->html( $this->translate( 'admin', 'Option' ) ); ?></span>
											<div class="form-text text-muted help-text">
												<?= $enc->html( $this->translate( 'admin', 'Article specific configuration options, will be available as key/value pairs in the templates' ) ); ?>
											</div>
										</th>
										<th>
											<?= $enc->html( $this->translate( 'admin', 'Value' ) ); ?>
										</th>
										<th class="actions">
											<div class="btn act-add fa" tabindex="<?= $this->get( 'tabindex' ); ?>"
												title="<?= $enc->attr( $this->translate( 'admin', 'Insert new entry (Ctrl+I)') ); ?>">
											</div>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr class="prototype">
										<td>
											<input type="text" class="config-key form-control" tabindex="<?= $this->get( 'tabindex' ); ?>" disabled="disabled"
												name="<?= $enc->attr( $this->formparam( array( 'product', 'config', 'idx', 'key', '' ) ) ); ?>" />
										</td>
										<td>
											<input type="text" class="config-value form-control" tabindex="<?= $this->get( 'tabindex' ); ?>" disabled="disabled"
												name="<?= $enc->attr( $this->formparam( array( 'product', 'config', 'idx', 'val', '' ) ) ); ?>" />
										</td>
										<td class="actions">
											<div class="btn act-delete fa" tabindex="<?= $this->get( 'tabindex' ); ?>"
												title="<?= $enc->attr( $this->translate( 'admin', 'Delete this entry') ); ?>">
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</td>
				<td class="actions">
					<a class="btn fa act-close" href="#" tabindex="<?= $this->get( 'tabindex' ); ?>"
						title="<?= $enc->attr( $this->translate( 'admin', 'Close') ); ?>"
						aria-label="<?= $enc->attr( $this->translate( 'admin', 'Close' ) ); ?>">
					</a>
				</td>
			</tr>

			<?php foreach( $this->get( 'productData/customer.lists.id', [] ) as $idx => $listId ) : ?>
				<?php $siteId = $this->get( 'productData/customer.lists.siteid/' . $idx ); ?>
				<?php $refId = $this->get( 'productData/customer.lists.refid/' . $idx ); ?>

				<tr class="list-item <?= $this->site()->readonly( $siteId ); ?>">
					<?php if( in_array( 'customer.lists.position', $fields ) ) : ?>
						<td class="customer-lists-position">
							<input class="form-control item-position" type="number" step="1" tabindex="<?= $this->get( 'tabindex' ); ?>"
								name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.position', '' ) ) ); ?>"
								value="<?= $enc->attr( $this->get( 'productData/customer.lists.position/' . $idx ) ); ?>"
								<?= $this->site()->readonly( $siteId ); ?> disabled="disabled" />
						</td>
					<?php endif; ?>
					<?php if( in_array( 'customer.lists.status', $fields ) ) : ?>
						<td class="customer-lists-status">
							<select class="form-control custom-select item-status" required="required" tabindex="<?= $this->get( 'tabindex' ); ?>"
								name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.status', '' ) ) ); ?>"
								<?= $this->site()->readonly( $siteId ); ?> disabled="disabled" >
								<option value="">
									<?= $enc->html( $this->translate( 'admin', 'Please select' ) ); ?>
								</option>
								<option value="1" <?= $selected( $this->get( 'productData/customer.lists.status/' . $idx, 1 ), 1 ); ?> >
									<?= $enc->html( $this->translate( 'mshop/code', 'status:1' ) ); ?>
								</option>
								<option value="0" <?= $selected( $this->get( 'productData/customer.lists.status/' . $idx, 1 ), 0 ); ?> >
									<?= $enc->html( $this->translate( 'mshop/code', 'status:0' ) ); ?>
								</option>
								<option value="-1" <?= $selected( $this->get( 'productData/customer.lists.status/' . $idx, 1 ), -1 ); ?> >
									<?= $enc->html( $this->translate( 'mshop/code', 'status:-1' ) ); ?>
								</option>
								<option value="-2" <?= $selected( $this->get( 'productData/customer.lists.status/' . $idx, 1 ), -2 ); ?> >
									<?= $enc->html( $this->translate( 'mshop/code', 'status:-2' ) ); ?>
								</option>
							</select>
						</td>
					<?php endif; ?>
					<?php if( in_array( 'customer.lists.typeid', $fields ) ) : ?>
						<td class="customer-lists-typeid">
							<select class="form-control custom-select item-typeid" required="required" tabindex="<?= $this->get( 'tabindex' ); ?>"
								name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.typeid', '' ) ) ); ?>"
								<?= $this->site()->readonly( $siteId ); ?> disabled="disabled" >
								<option value="">
									<?= $enc->html( $this->translate( 'admin', 'Please select' ) ); ?>
								</option>

								<?php foreach( $this->get( 'productListTypes', [] ) as $id => $type ) : ?>
									<option value="<?= $enc->attr( $id ); ?>" <?= $selected( $this->get( 'productData/customer.lists.typeid/' . $idx ), $id ); ?> >
										<?= $enc->html( $type ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</td>
					<?php endif; ?>
					<?php if( in_array( 'customer.lists.config', $fields ) ) : ?>
						<td class="customer-lists-config item-config">
							<div class="config-type config-type-map">
								<input type="text" class="config-value form-control" tabindex="<?= $this->get( 'tabindex' ); ?>"
									name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.config', '' ) ) ); ?>"
									value="<?= $enc->attr( json_encode( $this->get( 'productData/customer.lists.config/' . $idx ) ) ); ?>"
									<?= $this->site()->readonly( $siteId ); ?> disabled="disabled" />

								<table class="table table-striped config-map-table">
									<tr class="config-map-row prototype-map">
										<td class="config-map-actions">
											<div class="btn act-delete fa" tabindex="1"
												title="<?= $enc->attr( $this->translate( 'admin', 'Delete this entry') ); ?>">
											</div>
										</td>
										<td class="config-map-row-key">
											<input type="text" class="config-map-key form-control" tabindex="1" disabled="disabled" name="" />
										</td>
										<td class="config-map-row-value">
											<input type="text" class="config-map-value form-control" tabindex="1" disabled="disabled" name="" />
										</td>
									</tr>
									<tr class="config-map-actions">
										<td class="config-map-action-add">
											<div class="btn act-add fa" tabindex="1"
												title="<?= $enc->attr( $this->translate( 'admin', 'Insert new entry') ); ?>">
											</div>
										</td>
										<td class="config-map-action-update" colspan="2">
											<div class="btn btn-primary act-update" tabindex="1">
												<?= $enc->attr( $this->translate( 'admin', 'OK') ); ?>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</td>
					<?php endif; ?>
					<?php if( in_array( 'customer.lists.datestart', $fields ) ) : ?>
						<td class="customer-lists-datestart">
							<input class="form-control item-datestart" type="datetime-local" tabindex="<?= $this->get( 'tabindex' ); ?>"
								name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.datestart', '' ) ) ); ?>"
								value="<?= $enc->attr( str_replace( ' ', 'T', $this->get( 'productData/customer.lists.datestart/' . $idx ) ) ); ?>"
								<?= $this->site()->readonly( $siteId ); ?> disabled="disabled" />
						</td>
					<?php endif; ?>
					<?php if( in_array( 'customer.lists.dateend', $fields ) ) : ?>
						<td class="customer-lists-dateend">
							<input class="form-control item-dateend" type="datetime-local" tabindex="<?= $this->get( 'tabindex' ); ?>"
								name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.dateend', '' ) ) ); ?>"
								value="<?= $enc->attr( str_replace( ' ', 'T', $this->get( 'productData/customer.lists.dateend/' . $idx ) ) ); ?>"
								<?= $this->site()->readonly( $siteId ); ?> disabled="disabled" />
						</td>
					<?php endif; ?>

					<?php $refItem = ( isset( $refItems[$refId] ) ? $refItems[$refId] : null ); ?>

					<?php if( in_array( 'customer.lists.refid', $fields ) ) : ?>
						<td class="customer-lists-refid">
							<input class="form-control item-refid" type="hidden"
								name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.refid', '' ) ) ); ?>"
								value="<?= $enc->attr( $refId ); ?>" disabled="disabled" />
							<?php if( $refItem ) : ?>
								<a class="btn act-view fa item-refid" tabindex="<?= $this->get( 'tabindex' ); ?>" target="_blank"
									href="<?= $enc->attr( $this->url( $getTarget, $getCntl, $getAction, ['resource' => 'product', 'id' => $refId] + $params, [], $getConfig ) ); ?>"
									title="<?= $enc->attr( $this->translate( 'admin', 'Show entry') ); ?>"
									aria-label="<?= $enc->attr( $this->translate( 'admin', 'Show' ) ); ?>">
									<?= $enc->html( $refId ); ?> - <?= $enc->html( $refItem->getLabel() . ' (' . $refItem->getCode() . ')' ); ?>
								</a>
							<?php else : ?>
								<?= $enc->html( $refId ); ?> (<?= $enc->html( $this->translate( 'admin', 'not available any more' ) ); ?>)
							<?php endif; ?>
						</td>
					<?php endif; ?>

					<td class="actions">
						<input type="hidden" value="<?= $enc->attr( $listId ); ?>" disabled="disabled"
							name="<?= $enc->attr( $this->formparam( array( 'product', 'customer.lists.id', '' ) ) ); ?>" />

						<?php if( !$this->site()->readonly( $siteId ) ) : ?>
							<a class="btn act-edit fa" tabindex="<?= $this->get( 'tabindex' ); ?>" href="#"
								title="<?= $enc->attr( $this->translate( 'admin', 'Edit this entry') ); ?>"
								aria-label="<?= $enc->attr( $this->translate( 'admin', 'Edit' ) ); ?>"></a>
							<a class="btn act-delete fa" tabindex="<?= $this->get( 'tabindex' ); ?>"
								href="<?= $enc->attr( $this->url( $delTarget, $delCntl, $delAction, ['resource' => 'customer/lists', 'id' => $listId] + $params, [], $delConfig ) ); ?>"
								title="<?= $enc->attr( $this->translate( 'admin', 'Delete this entry') ); ?>"
								aria-label="<?= $enc->attr( $this->translate( 'admin', 'Delete' ) ); ?>"></a>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>

		</tbody>
	</table>

	<?php if( $this->get( 'productData', [] ) === [] ) : ?>
		<div class="noitems"><?= $enc->html( sprintf( $this->translate( 'admin', 'No items found' ) ) ); ?></div>
	<?php endif; ?>

	<?= $this->partial(
			$this->config( 'admin/jqadm/partial/pagination', 'common/partials/pagination-standard.php' ),
			['pageParams' => $params, 'pos' => 'bottom', 'total' => $this->get( 'productTotal' ),
			'group' => 'up', 'action' => 'get', 'fragment' => 'product',
			'page' =>$this->session( 'aimeos/admin/jqadm/customerproduct/page', [] )]
		);
	?>

</div>
<?= $this->get( 'productBody' ); ?>
