import ProductDetails from "@/components/product/ProductDetails";
import { getSingleProduct } from "@/services/product.service";

export default async function SingleProduct({
  params,
}: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await params;

  const product = await getSingleProduct(slug);

  return (
    <>
      <ProductDetails product={product} />
    </>
  );
}
