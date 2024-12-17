'use client'

import { useState, useEffect } from 'react'
import { Button } from "@/components/ui/button"
import { Card, CardContent } from "@/components/ui/card"
import { Smartphone, Zap, Eye, Fingerprint } from 'lucide-react'
import Image from 'next/image'

const features = [
  { icon: Smartphone, title: "Mobile Optimized", description: "Designed for the devices you use most" },
  { icon: Zap, title: "Lightning Fast", description: "Optimized for speed and performance" },
  { icon: Eye, title: "User-Friendly", description: "Intuitive interface for effortless navigation" },
  { icon: Fingerprint, title: "Secure", description: "Your data is safe and protected" }
]

export function MobileExperienceSection() {
  const [activeFeature, setActiveFeature] = useState(0)
  const [isScrolling, setIsScrolling] = useState(false)

  useEffect(() => {
    const interval = setInterval(() => {
      if (!isScrolling) {
        setActiveFeature((prev) => (prev + 1) % features.length)
      }
    }, 3000)

    return () => clearInterval(interval)
  }, [isScrolling])

  return null
}

