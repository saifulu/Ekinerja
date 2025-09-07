// ... existing code ...

// Relationship dengan UnitRuangan
public function unitRuangan()
{
    return $this->hasMany(UnitRuangan::class, 'nip', 'nip');
}

// ... existing code ...