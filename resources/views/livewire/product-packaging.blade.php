<div>
	{{-- The whole world belongs to you. --}}
	@if (session()->has('message'))
		<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
			<h4 class="alert-heading">Awesomeness!</h4>
			<p>{{ session('message') }}</p>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@elseif(session()->has('error'))
		<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
			<h4 class="alert-heading">Oops!</h4>
			<p>{{ session('error') }}</p>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif
	<div class="flex h-screen justify-center items-center">
		<div class="row w-75">
			<div class="row mt-4">
				@if ($product)
					<div class="col-sm-12 col-md-12 mb-3">
						<img class="card-img-top img-fluid" src="{{ $product->package }}" alt="Product Packaging">
					</div>
				@endif
			</div>
			<div class="col-md-12">
				<form class="mb-5" wire:submit.prevent="store">
					<div class="form-group row mt-3 mb-3">
						<div class="input-group mb-3">
							<input id="package" type="file" class="form-control @error('package') is-invalid @enderror"
							       placeholder="Choose files..." wire:model="package">
							<label class="input-group-text" for="package">
								Upload Product Packaging...
							</label>
							@error('package')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="input-group mb-5">
							<label class="input-group-text" for="location">QRCode Position</label>
							<select id="location" type="file" class="form-select @error('location') is-invalid @enderror"
							        wire:model="location">
								<option selected>Select Position ...</option>
								<option selected value="north_east">Top Right</option>
								<option value="north_west">Top Left</option>
								<option value="south_east">Bottom Right</option>
								<option value="south_west">Bottom Left</option>
								<option value="center">Center</option>
							</select>
							@error('location')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1">Name</span>
							<input class="form-control @error('name') is-invalid @enderror" placeholder="Product Name"
							       aria-label="Product Name"
							       aria-describedby="basic-addon1" wire:model="name">
							@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1">Price</span>
							<input type="number" class="form-control @error('price') is-invalid @enderror" placeholder="Product Price"
							       aria-label="Product Price"
							       aria-describedby="basic-addon1" wire:model="price">
							@error('price')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1">Short Desc</span>
							<input type="text" class="form-control @error('short_desc') is-invalid @enderror"
							       placeholder="Product Short Desc"
							       aria-label="Product Short Desc"
							       aria-describedby="basic-addon1" wire:model="short_desc">
							@error('short_desc')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1">Desc</span>
							<textarea class="form-control @error('desc') is-invalid @enderror" placeholder="Product Desc"
							          aria-label="Product Desc"
							          aria-describedby="basic-addon1" wire:model="desc"></textarea>
							@error('desc')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<small class="text-muted text-center mt-2" wire:loading wire:target="package">
							{{ __('Uploading') }}&hellip;
						</small>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-sm btn-primary">
							{{ __('Create New Product') }}
							<i class="spinner-border spinner-border-sm ml-1 mt-1" wire:loading wire:target="store"></i>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
