<?php declare(strict_types = 1);

namespace WebChemistry\Responses;

use Nette;
use Nette\Application\IResponse;

class StringResponse implements IResponse {

	/** @var string */
	private $content;

	/** @var string */
	private $fileName;

	/** @var string */
	private $contentType;

	/** @var bool */
	private $forceDownload = true;

	public function __construct(string $content, string $fileName, string $contentType = ContentTypes::TEXT) {
		$this->content = $content;
		$this->fileName = $fileName;
		$this->contentType = $contentType;
	}

	public function setForceDownload(bool $forceDownload): void {
		$this->forceDownload = $forceDownload;
	}

	public function send(Nette\Http\IRequest $httpRequest, Nette\Http\IResponse $httpResponse) {
		$httpResponse->addHeader('Content-Type', $this->contentType);
		$httpResponse->addHeader(
			'Content-Disposition',
			($this->forceDownload ? 'attachment;' : '') . 'filename="' . $this->fileName . '"');
		$httpResponse->addHeader('Content-Length', mb_strlen($this->content));

		echo $this->content;
	}

}
