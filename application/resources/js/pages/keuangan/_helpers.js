// resources/js/pages/keuangan/_helpers.js

const colorPalette = [
  // =================================================================
  // GROUP 1: THE CORE FINANCIAL (9 Warna: Kepercayaan, Stabilitas, Pertumbuhan)
  // Karakter: Deep Blues, Slate, Teal, Emerald Green
  // Cocok untuk: Kategori utama (Pendapatan, Tabungan, Investasi, Cicilan)
  // =================================================================
  '#1E3A8A', '#2563EB', '#3B82F6', // Deep Blue ke Bright Blue
  '#0D9488', '#14B8A6', '#2E7D32', // Deep Teal, Mint Teal, Emerald
  '#4CAF50', '#81C784', '#154360', // Vibrant Green, Soft Green, Navy Grey

  // =================================================================
  // GROUP 2: SOFT PASTELS & BALANCERS (9 Warna: Keseimbangan visual)
  // Karakter: Muted Purple, Lavender, Soft Lilac, Cool Grey
  // Cocok untuk: Kategori rutin/sekunder (Utilitas, Tagihan Bulanan, Edukasi)
  // =================================================================
  '#6366F1', '#8B5CF6', '#A78BFA', // Indigo, Purple, Soft Violet
  '#A3E635', '#0284C7', '#38BDF8', // Lime Green, Sky Blue, Light Cyan
  '#64748B', '#94A3B8', '#CBD5E1', // Slate Grey (Tua, Sedang, Muda untuk penyeimbang)

  // =================================================================
  // GROUP 3: WARM & COZY TONES (9 Warna: Aksentuasi Terkontrol)
  // Karakter: Coral, Terracotta, Soft Amber, Champagne Gold
  // Cocok untuk: Kategori fleksibel/gaya hidup (Belanja, Hiburan, Kuliner)
  // Diturunkan saturasinya agar tidak terlalu menusuk mata seperti warna neon.
  // =================================================================
  '#E11D48', '#F43F5E', '#FB7185', // Rose, Coral Pink, Soft Pink
  '#EA580C', '#F97316', '#FDBA74', // Terracotta, Warm Orange, Pastel Amber
  '#D97706', '#F59E0B', '#FDE047', // Muted Amber, Soft Yellow, Light Yellow

  // =================================================================
  // GROUP 4: REFINED EARTH & LUXURY (8 Warna: Elemen Pelengkap)
  // Karakter: Bronze, Maroon, Olive, Charcoal, Warm Grey
  // Cocok untuk: Kategori tak terduga, pajak, asuransi, atau "Lain-lain"
  // =================================================================
  '#78350F', '#B45309', '#9A3412', // Dark Bronze, Ochre, Burnt Brick
  '#881337', '#9D174D', '#556B2F', // Maroon, Crimson, Olive Green
  '#334155', '#1E293B'              // Dark Charcoal, Deep Space (Untuk sisa kategori terakhir)
];

export function getColorPalette(count) {
  const colors = [];
  for (let i = 0; i < count; i++) {
    colors.push(colorPalette[i % colorPalette.length]);
  }
  return colors;
}