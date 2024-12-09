<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelCatalogProductCategory extends Model {
	public function getProductsByCategory($filter_data) {
		$sql = "SELECT p.product_id, pd.name, p.price, p.status, p.date_added
				FROM " . DB_PREFIX . "product_to_category pc
				JOIN " . DB_PREFIX . "product p ON pc.product_id = p.product_id
				JOIN " . DB_PREFIX . "product_description pd ON p.product_id = pd.product_id
				WHERE pc.category_id = '" . (int)$filter_data['category_id'] . "'
				  AND p.status = 1
				  AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
	
		// Додаємо сортування
		if (!empty($filter_data['sort']) && in_array($filter_data['sort'], ['p.price', 'pd.name', 'p.date_added'])) {
			$sql .= " ORDER BY " . $filter_data['sort'];
		} else {
			$sql .= " ORDER BY pd.name"; // Значення за замовчуванням
		}
	
		// Додаємо порядок сортування
		if (!empty($filter_data['order']) && in_array(strtoupper($filter_data['order']), ['ASC', 'DESC'])) {
			$sql .= " " . strtoupper($filter_data['order']);
		} else {
			$sql .= " ASC"; // Значення за замовчуванням
		}
	
		// Додаємо обмеження
		if (!empty($filter_data['limit']) && (int)$filter_data['limit'] > 0) {
			$sql .= " LIMIT " . (int)$filter_data['limit'];
		} else {
			$sql .= " LIMIT 10"; // Значення за замовчуванням
		}
	
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	
}