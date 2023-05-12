<?php

class Contents
{
	private $contents;

	public function __construct()
	{
		$file = fopen('contents.csv', 'r');
		$this->contents = [];

		while($row = fgetcsv($file)) {
			$identifier = $row[1];

			$node = (object) [
				'title' => $row[0],
				'contents' => [],
			];

			for($i = 2; $i < count($row); $i++) {
				$line = trim($row[$i]);
				if ($line) {
					$node->contents[] = $line;
				}
			}

			$this->contents[$identifier] = $node;
		}
	}

	public function get($identifier)
	{
		return $this->contents[$identifier];
	}

	public function getAll()
	{
		return $this->contents;
	}

	public function printCell($identifier)
	{
		$node = $this->contents[$identifier];
		$title = str_replace(' – ', '<br>', $node->title);

		if (empty($node->contents)) {
			return sprintf('%s', $title);
		}
		else {
			return sprintf('<a href="#" data-bs-toggle="modal" data-bs-target="#%s">%s</a>', $identifier, $title);
		}
	}
}
