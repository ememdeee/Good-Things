import Link from 'next/link'
import { Facebook, Twitter, Instagram, Linkedin } from 'lucide-react'

export function Footer() {
  return (
    <footer className="border-t bg-background">
      <div className="container px-4 py-12 md:py-16 lg:py-20 mx-auto">
        <div className="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
          <div>
            <h3 className="mb-4 text-lg font-semibold">Vehicle History</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/sample-report" className="text-muted-foreground hover:text-foreground">
                  Sample Report
                </Link>
              </li>
              <li>
                <Link href="/license-plate-lookup" className="text-muted-foreground hover:text-foreground">
                  License Plate Lookup
                </Link>
              </li>
              <li>
                <Link href="/" className="text-muted-foreground hover:text-foreground">
                  VIN Decoder
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <h3 className="mb-4 text-lg font-semibold">Window Stickers</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/window-sticker" className="text-muted-foreground hover:text-foreground">
                  Get Window Sticker
                </Link>
              </li>
              <li>
                <Link href="/sample-sticker" className="text-muted-foreground hover:text-foreground">
                  Sample Sticker
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <h3 className="mb-4 text-lg font-semibold">Services</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/pricing" className="text-muted-foreground hover:text-foreground">
                  Pricing
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <h3 className="mb-4 text-lg font-semibold">Company</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/contact" className="text-muted-foreground hover:text-foreground">
                  Contact
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <h3 className="mb-4 text-lg font-semibold">Legal</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/terms" className="text-muted-foreground hover:text-foreground">
                  Terms of Service
                </Link>
              </li>
              <li>
                <Link href="/privacy" className="text-muted-foreground hover:text-foreground">
                  Privacy Policy
                </Link>
              </li>
            </ul>
          </div>
        </div>
        <div className="mt-12 border-t pt-8 text-center">
          <div className="flex justify-center space-x-4 mb-4">
            <Link href="#" className="text-muted-foreground hover:text-foreground">
              <Facebook className="h-5 w-5" />
            </Link>
            <Link href="#" className="text-muted-foreground hover:text-foreground">
              <Twitter className="h-5 w-5" />
            </Link>
            <Link href="#" className="text-muted-foreground hover:text-foreground">
              <Instagram className="h-5 w-5" />
            </Link>
            <Link href="#" className="text-muted-foreground hover:text-foreground">
              <Linkedin className="h-5 w-5" />
            </Link>
          </div>
          <p className="text-sm text-muted-foreground">
            © {new Date().getFullYear()} VehicleInsights. All rights reserved.
          </p>
        </div>
      </div>
    </footer>
  )
}

