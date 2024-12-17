'use client'

import { Button } from '@/components/ui/button'
import { MessageCircle } from 'lucide-react'

export function SupportButton() {
  return (
    <Button
      className="fixed bottom-4 right-4 z-50 rounded-full shadow-lg"
      size="lg"
      onClick={() => {
        // Implement chat functionality
        console.log('Open support chat')
      }}
    >
      <MessageCircle className="mr-2 h-4 w-4" />
      24/7 Support
    </Button>
  )
}

