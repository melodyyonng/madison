<?php
/**
 * 	Controller for admin dashboard
 */
class DashboardController extends BaseController{
	
	public $restful = true;
	
	public function __construct(){
		//Filter to ensure user is signed in and is user_level == 1
		$this->beforeFilter('admin');
		
		//Run csrf filter before all posts
		$this->beforeFilter('csrf', array('on'=>'post'));
		
		parent::__construct();
	}
	
	/**
	 * 	Dashboard Index View
	 */
	public function getIndex(){
		$data = array(
			'page_id'		=> 'dashboard',
			'page_title'	=> 'Dashboard'
		);

		return View::make('dashboard.index', $data);
	}

	/**
	 * 	Document Creation/List or Document Edit Views
	 */
	public function getDocs($id = ''){
		if($id == ''){
			$docs = Doc::all();

			$data = array(
				'page_id'		=> 'doc_list',
				'page_title'	=> 'Edit Documents',
				'docs'			=> $docs
			);

			return View::make('dashboard.docs', $data);
		}
		else{
			$doc = Doc::find($id);
			if(isset($doc)){
				$data = array(
					'page_id'		=> 'edit_doc',
					'page_title'	=> 'Edit ' . $doc->title,
					'doc'			=> $doc,
					// Just get the first content element.  We only have one, now.
					'contentItem' => $doc->content()->where('parent_id')->first()
				);

				return View::make('dashboard.edit-doc', $data);
			}
			else{
				return Response::error('404');
			}
		}
	}
	
	/**
	 * 	Post route for creating / updating documents
	 */
	public function postDocs($id = ''){
		//Creating new document
		if($id == ''){
			$title = Input::get('title');
			$slug = Input::get('slug');
			$doc_details = Input::all();

			$rules = array('title' => 'required',
							'slug' => 'required|unique:docs'
							);
			$validation = Validator::make($doc_details, $rules);
			if($validation->fails()){
				return Redirect::to('dashboard/docs')->with_input()->with_errors($validation);
			}

			try{
				$doc = new Doc();
				$doc->title = $title;
				$doc->slug = $slug;
				$doc->save();

				$starter = new DocContent();
				$starter->doc_id = $doc->id;
				$starter->content = "New Doc Content";
				$starter->save();

				$doc->init_section = $starter->id;
				$doc->save();

				return Redirect::to('dashboard/docs/' . $doc->id)->with('success_message', 'Document created successfully');
			}catch(Exception $e){
				return Redirect::to('dashboard/docs')->with_input()->with('error', $e->getMessage());
			}
		}
		else{
			return Response::error('404');
		}
	}

	/**
	 * 	PUT route for saving documents
	 */
	public function putDocs($id = ''){
		$content = Input::get('content');
		$content_id = Input::get('content_id');

		if($content_id){
			try{
				$doc_content = DocContent::find($content_id);
			}catch (Exception $e){
				return Redirect::to('dashboard/docs/' . $id)->with('error', 'Error saving the document: ' . $e->getMessage());
			}
		}
		else{
			$doc_content = new DocContent();
		}

		$doc_content->doc_id = $id;
		$doc_content->content = $content;
		$doc_content->save();

		$doc = Doc::find($id);
		$doc->store_content($doc, $doc_content);

		return Redirect::to('dashboard/docs/' . $id)->with('success_message', 'Document Saved Successfully');
	}
	
	/**
	 * 	Verification request view
	 */
	public function getVerifications(){
		$requests = UserMeta::where('meta_key', 'verify')->with('user')->get();

		$data = array(
			'page_id'		=> 'verify_users',
			'page_title'	=> 'Verify Users',
			'requests'		=> $requests
		);

		return View::make('dashboard.verify-account', $data);
	}

	/**
	*	Settings page
	*/

	public function getSettings(){
		$data = array(
			'page_id'		=> 'settings',
			'page_title'	=> 'Settings',
		);

		return View::make('dashboard.settings', $data);
	}

	public function postSettings(){
		$adminEmail = Input::get('contact-email');

		$adminContact = User::where('email', '$adminEmail');

		if(!isset($adminContact)){
			return Redirect::back()->with('error', 'The admin account with this email was not found.  Please try a different email.');
		}





	}
}

