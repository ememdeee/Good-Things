import Link from 'next/link'
import { Facebook, Twitter, Instagram, Linkedin } from 'lucide-react'

const scrollToTop = (e: React.MouseEvent<HTMLAnchorElement>) => {
  const href = e.currentTarget.href;
  if (href.startsWith(window.location.origin) || href.startsWith('/')) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
    // Use Next.js router to change the URL without a full page reload
    const newPath = href.replace(window.location.origin, '');
    window.history.pushState({}, '', newPath);
  }
};

export function Footer() {
  return (
    <footer className="border-t bg-background">
      <div className="container px-4 py-12 md:py-16 lg:py-20">
        <div className="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
          <div>
            <h3 className="mb-4 text-lg font-semibold">Vehicle History</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/sample-report" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
                  Sample Report
                </Link>
              </li>
              <li>
                <Link href="/license-plate-lookup" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
                  License Plate Lookup
                </Link>
              </li>
              <li>
                <Link href="/" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
                  VIN Decoder
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <h3 className="mb-4 text-lg font-semibold">Window Stickers</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/window-sticker" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
                  Get Window Sticker
                </Link>
              </li>
              <li>
                <Link href="/sample?tab=sticker" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
                  Sample Sticker
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <h3 className="mb-4 text-lg font-semibold">Services</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/pricing" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
                  Pricing
                </Link>
              </li>
              <li>
                <Link href="/for-dealers" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
                  For Dealers
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <h3 className="mb-4 text-lg font-semibold">Company</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/about" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
                  About Us
                </Link>
              </li>
              <li>
                <Link href="/contact" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
                  Contact
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <h3 className="mb-4 text-lg font-semibold">Legal</h3>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/terms" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
                  Terms of Service
                </Link>
              </li>
              <li>
                <Link href="/privacy" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
                  Privacy Policy
                </Link>
              </li>
            </ul>
          </div>
        </div>
        <div className="mt-12 border-t pt-8 text-center">
          <div className="flex justify-center space-x-4 mb-4">
            <Link href="#" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
              <Facebook className="h-5 w-5" />
            </Link>
            <Link href="#" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
              <Twitter className="h-5 w-5" />
            </Link>
            <Link href="#" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
              <Instagram className="h-5 w-5" />
            </Link>
            <Link href="#" className="text-muted-foreground hover:text-foreground" onClick={scrollToTop}>
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

