#include <cmath>

void drawLineDDA(int x1, int x2, int y1, int y2)
{
  // TODO : Calculate Distance dx, dy
  float dx = x2 - x1;
  float dy = y2 - y1;

  // TODO : Calculate steps required
  //* If line is wider (dx > dy), we step along X.
  //* If line is taller (dy > dx), we step along Y.
  float steps;
  if (abs(dx) > abs(dy))
  {
    steps = abs(dx);
  }
  else
  {
    steps = abs(dy);
  }

  // TODO : Calculate how much to add per step (Increment)
  float xIncrement = dx / steps;
  float yIncrement = dy / steps;

  // TODO : Start Loop
  float x = x1;
  float y = y1;

  for (int i = 0; i <= steps; i++)
  {
    //* putpixel is the standard command to light up a dot
    //* We must ROUND the coordinates to the nearest integer
    putpixel(round(x), round(y), WHITE);

    x += xIncrement;
    y += yIncrement;
  }
}