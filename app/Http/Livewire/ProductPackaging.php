<?php
	
	namespace App\Http\Livewire;
	
	use App\Models\Product;
	use Illuminate\Support\Str;
	use Livewire\Component;
	use Livewire\WithFileUploads;
	use SimpleSoftwareIO\QrCode\Facades\QrCode;
	
	class ProductPackaging extends Component {
		use WithFileUploads;
		
		public $media;
		public $package;
		public $name;
		public $price;
		public $short_desc;
		public $desc;
		public $location;
		public $qrCodeId;
		public $product;
		
		public function store() {
			$data = $this->validate([
				'package'    => [
					'required',
					'image',
					'mimes:jpeg,jpg,png',
					'max:1024'
				],
				'name'       => [
					'required',
					'string',
					'max:100'
				],
				'price'      => [
					'required',
					'integer',
				],
				'short_desc' => [
					'required',
					'string',
					'max:140'
				],
				'desc'       => [
					'required',
					'string',
					'max:300'
				],
				'location'   => [
					'required',
					'string'
				]
			]);
			
			//create qr code
			$qrCodeData = $data['desc'];
			$qrCodePath = '../storage/product_qr_code.svg';
			QrCode::format('svg')->size(150)->style('round')->backgroundColor(255, 255, 255, 0)->color(0, 0, 0, 90)->margin(5)->generate($qrCodeData, $qrCodePath);
			
			//upload qr code
			$this->qrCodeId = cloudinary()->upload($qrCodePath, [
				'folder'         => 'product-qrcodes',
				'public_id'      => Str::uuid()->toString(),
				'transformation' => [
					'width'  => '150',
					'height' => '150'
				]
			])->getPublicId();
			
			//create packaging with cloudinary and get URL
			$this->package = cloudinary()->upload($data['package']->getRealPath(), [
				'folder'         => 'product-qrcodes',
				'transformation' => [
					'overlay' => $this->qrCodeId,
					'gravity' => $data['location'], // watermark location bottom right
					'x'       => 0.02, // 2 percent offset horizontally
					'y'       => 0.02, // 2 percent offset vertically
					'crop'    => 'scale',
					'opacity' => 70
				],
			])->getSecurePath();
			
			$data['package'] = $this->package;
			
			$this->product = Product::create($data);
			$productName = $this->product->name;
			
			session()->flash('message', "Product $productName generated successfully!");
		}
		
		public function render() {
			return view('livewire.product-packaging');
		}
	}
