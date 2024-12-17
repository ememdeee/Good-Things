import { Button } from '@/components/ui/button'
import Link from 'next/link'

interface CTASectionProps {
  title: string
  description: string
  buttonText: string
  buttonLink: string
}

export function CTASection({ title, description, buttonText, buttonLink }: CTASectionProps) {
  return (
    <div className="mt-12 text-center">
      <h2 className="text-2xl font-bold mb-4">
        {title}
      </h2>
      <p className="text-gray-600 mb-6">
        {description}
      </p>
      <Link href={buttonLink}>
        <Button size="lg">
          {buttonText}
        </Button>
      </Link>
    </div>
  )
}
