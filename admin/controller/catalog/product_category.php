<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCatalogProductCategory extends Controller {
	private $error = array();
	private $path = array();

	public function get() {
		$this->load->language('catalog/category');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product_category');
	
		// Отримуємо дані з запиту
		$category_id = isset($this->request->get['category_id']) ? (int)$this->request->get['category_id'] : 0;
		$limit = isset($this->request->get['limit']) ? (int)$this->request->get['limit'] : 10;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'p.name';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
	
		// Перевірка ID категорії
		if ($category_id <= 0) {
			$this->response->setOutput(json_encode(['error' => 'Invalid category ID']));
			return;
		}
	
		// Отримання списку товарів
		$filter_data = [
			'category_id' => $category_id,
			'limit' => $limit,
			'sort' => $sort,
			'order' => $order,
		];
	
		$products = $this->model_catalog_product_category->getProductsByCategory($filter_data);
	
		// Формуємо JSON-відповідь
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($products));
	}

}