<?php declare(strict_types=1);

namespace Jeppos\ShopifySDK\Service;

use GuzzleHttp\Exception\GuzzleException;
use Jeppos\ShopifySDK\Client\ShopifyBadResponseException;
use Jeppos\ShopifySDK\Client\ShopifyException;
use Jeppos\ShopifySDK\Client\ShopifyInvalidResponseException;
use Jeppos\ShopifySDK\Model\Metafield;
use Jeppos\ShopifySDK\Model\Product;

/**
 * @see https://help.shopify.com/en/api/reference/products/product
 */
class ProductService extends AbstractService
{
    /**
     * @see https://help.shopify.com/en/api/reference/products/product#show
     *
     * @param int $productId
     * @return Product
     * @throws GuzzleException
     * @throws ShopifyBadResponseException
     * @throws ShopifyException
     * @throws ShopifyInvalidResponseException
     */
    public function getOne(int $productId): Product
    {
        $response = $this->client->get(sprintf('products/%d.json', $productId));

        return $this->serializer->deserialize($response, Product::class);
    }

    /**
     * @see https://help.shopify.com/en/api/reference/products/product#index
     *
     * @param array $options
     * @return Product[]
     * @throws GuzzleException
     * @throws ShopifyBadResponseException
     * @throws ShopifyException
     * @throws ShopifyInvalidResponseException
     */
    public function getList(array $options = []): array
    {
        $response = $this->client->get('products.json', $options);

        return $this->serializer->deserializeList($response, Product::class);
    }

    /**
     * @see https://help.shopify.com/en/api/reference/products/product#count
     *
     * @param array $options
     * @return int
     * @throws GuzzleException
     * @throws ShopifyBadResponseException
     * @throws ShopifyException
     * @throws ShopifyInvalidResponseException
     */
    public function getCount(array $options = []): int
    {
        return $this->client->get('products/count.json', $options);
    }

    /**
     * @see https://help.shopify.com/en/api/reference/products/product#create
     *
     * @param Product $product
     * @return Product
     * @throws GuzzleException
     * @throws ShopifyBadResponseException
     * @throws ShopifyException
     * @throws ShopifyInvalidResponseException
     */
    public function createOne(Product $product): Product
    {
        $response = $this->client->post('products.json', $this->serializer->serialize($product, 'product', ['post']));

        return $this->serializer->deserialize($response, Product::class);
    }

    /**
     * @see https://help.shopify.com/en/api/reference/products/product#update
     *
     * @param Product $product
     * @return Product
     * @throws GuzzleException
     * @throws ShopifyBadResponseException
     * @throws ShopifyException
     * @throws ShopifyInvalidResponseException
     */
    public function updateOne(Product $product): Product
    {
        $response = $this->client->put(
            sprintf('products/%d.json', $product->getId()),
            $this->serializer->serialize($product, 'product', ['put'])
        );

        return $this->serializer->deserialize($response, Product::class);
    }

    /**
     * @see https://help.shopify.com/en/api/reference/products/product#destroy
     *
     * @param int $productId
     * @return bool
     * @throws GuzzleException
     * @throws ShopifyBadResponseException
     * @throws ShopifyException
     */
    public function deleteOne(int $productId): bool
    {
        return $this->client->delete(sprintf('products/%d.json', $productId));
    }

    /**
     * @param int $productId
     * @return Metafield[]
     * @throws GuzzleException
     * @throws ShopifyBadResponseException
     * @throws ShopifyException
     * @throws ShopifyInvalidResponseException
     */
    public function getMetafields(int $productId): array
    {
        $response = $this->client->get(sprintf('products/%d/metafields.json', $productId));

        return $this->serializer->deserializeList($response, Metafield::class);
    }
}
