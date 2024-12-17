'use client'

import { useState, useEffect, useRef } from 'react'
import { motion } from 'framer-motion'
import { Card, CardContent } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { ChevronLeft, ChevronRight } from 'lucide-react'
import { cn } from "@/lib/utils"
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription } from "@/components/ui/dialog"

const stats = [
  { title: "VIN Reports Generated", value: "100M+", description: "Trusted by buyers and sellers worldwide." },
  { title: "Accurate Accident History", value: "99%", description: "Highly reliable accident reporting." },
  { title: "Vehicles Inspected Annually", value: "10M+", description: "Up-to-date, comprehensive reports." },
  { title: "Insurance Partners", value: "5,000+", description: "Verified data from trusted sources." },
  { title: "Auctions Analyzed Daily", value: "Thousands", description: "Complete auction history for every vehicle." },
  { title: "Buyers Feel More Confident", value: "95%", description: "Reports increase buyer confidence." },
  { title: "Data Points per Report", value: "20+", description: "Includes accidents, ownership, and title status." },
  { title: "Customer Support", value: "24/7", description: "Always here to help with any questions." },
  { title: "Verified Sellers", value: "50,000+", description: "Transparent listings for safe purchases." },
  { title: "Vehicles Have Clear Titles", value: "95%", description: "Peace of mind with each report." },
]

export function TrustStats() {
  const [currentIndex, setCurrentIndex] = useState(0)
  const [isMobile, setIsMobile] = useState(false)
  const [isVisible, setIsVisible] = useState(false)
  const [selectedStat, setSelectedStat] = useState<typeof stats[0] | null>(null)
  const sectionRef = useRef<HTMLElement>(null)

  useEffect(() => {
    const checkMobile = () => setIsMobile(window.innerWidth < 768)
    checkMobile()
    window.addEventListener('resize', checkMobile)
    return () => window.removeEventListener('resize', checkMobile)
  }, [])

  useEffect(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setIsVisible(true)
          observer.unobserve(entry.target)
        }
      },
      { threshold: 0.1 }
    )

    if (sectionRef.current) {
      observer.observe(sectionRef.current)
    }

    return () => {
      if (sectionRef.current) {
        observer.unobserve(sectionRef.current)
      }
    }
  }, [])

  const nextSlide = () => {
    setCurrentIndex((prevIndex) => (prevIndex + 1) % stats.length)
  }

  const prevSlide = () => {
    setCurrentIndex((prevIndex) => (prevIndex - 1 + stats.length) % stats.length)
  }

  return (
    <motion.section
      ref={sectionRef}
      initial={{ opacity: 0, y: 50 }}
      animate={isVisible ? { opacity: 1, y: 0 } : {}}
      transition={{ duration: 0.5 }}
      className="py-16 bg-gradient-to-br from-blue-50 to-purple-50"
    >
      <div className="container mx-auto px-4">
        <h2 className="text-3xl font-bold text-center mb-12 text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
          Trust in Numbers: Our Impact on Vehicle History
        </h2>
        <div className="relative">
          {isMobile ? (
            <div className="flex items-center justify-center">
              <Button variant="ghost" onClick={prevSlide} className="mr-4">
                <ChevronLeft className="h-6 w-6" />
              </Button>
              <Card className="w-full max-w-sm">
                <CardContent className="p-6 text-center">
                  <motion.div
                    key={currentIndex}
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    exit={{ opacity: 0, y: -20 }}
                    transition={{ duration: 0.3 }}
                  >
                    <h3 className="text-2xl font-bold mb-2">{stats[currentIndex].value}</h3>
                    <p className="text-lg font-semibold mb-2">{stats[currentIndex].title}</p>
                    <p className="text-gray-600">{stats[currentIndex].description}</p>
                  </motion.div>
                </CardContent>
              </Card>
              <Button variant="ghost" onClick={nextSlide} className="ml-4">
                <ChevronRight className="h-6 w-6" />
              </Button>
            </div>
          ) : (
            <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
              {stats.map((stat, index) => (
                <Card
                  key={index}
                  className="transition-all duration-300 hover:shadow-lg transform hover:scale-105 cursor-pointer"
                  onClick={() => setSelectedStat(stat)}
                >
                  <CardContent className="p-6 text-center">
                    <h3 className="text-2xl font-bold mb-2">{stat.value}</h3>
                    <p className="text-sm font-semibold mb-2">{stat.title}</p>
                    <p className="text-xs text-gray-600">{stat.description}</p>
                  </CardContent>
                </Card>
              ))}
            </div>
          )}
        </div>
      </div>
      <Dialog open={!!selectedStat} onOpenChange={() => setSelectedStat(null)}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>{selectedStat?.title}</DialogTitle>
            <DialogDescription>{selectedStat?.description}</DialogDescription>
          </DialogHeader>
          <p className="text-4xl font-bold text-center">{selectedStat?.value}</p>
        </DialogContent>
      </Dialog>
    </motion.section>
  )
}

