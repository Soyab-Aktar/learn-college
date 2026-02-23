#include <GL/glut.h>
#include <iostream>
using namespace std;

/* -------------------- Window Settings -------------------- */
int windowWidth = 600;
int windowHeight = 600;

/* -------------------- Read Pixel Color -------------------- */
void readPixelColor(int pixelX, int pixelY, float pixelColor[3])
{
  glReadPixels(pixelX, pixelY, 1, 1, GL_RGB, GL_FLOAT, pixelColor);
}
// (pixelX, pixelY) → location
// 1,1              → read 1 pixel only
// GL_RGB           → get Red, Green, Blue
// GL_FLOAT         → store as float values (0 to 1)
// pixelColor       → store result here

/* -------------------- Draw One Pixel -------------------- */
void drawPixel(int pixelX, int pixelY, float colorRGB[3])
{
  glColor3fv(colorRGB);
  glBegin(GL_POINTS);
  glVertex2i(pixelX, pixelY);
  glEnd();
  glFlush();
}

/* -------------------- Boundary Fill Algorithm (4-Connected) -------------------- */
void performBoundaryFill(int pixelX,
                         int pixelY,
                         float fillColorRGB[3],
                         float boundaryColorRGB[3])
{
  float currentColor[3];
  readPixelColor(pixelX, pixelY, currentColor);

  bool isBoundaryPixel =
      (currentColor[0] == boundaryColorRGB[0] &&
       currentColor[1] == boundaryColorRGB[1] &&
       currentColor[2] == boundaryColorRGB[2]);

  bool isAlreadyFilled =
      (currentColor[0] == fillColorRGB[0] &&
       currentColor[1] == fillColorRGB[1] &&
       currentColor[2] == fillColorRGB[2]);

  if (!isBoundaryPixel && !isAlreadyFilled)
  {
    drawPixel(pixelX, pixelY, fillColorRGB);

    // Check 4 neighbors
    performBoundaryFill(pixelX + 1, pixelY, fillColorRGB, boundaryColorRGB);
    performBoundaryFill(pixelX - 1, pixelY, fillColorRGB, boundaryColorRGB);
    performBoundaryFill(pixelX, pixelY + 1, fillColorRGB, boundaryColorRGB);
    performBoundaryFill(pixelX, pixelY - 1, fillColorRGB, boundaryColorRGB);
  }
}

/* -------------------- Draw Triangle Boundary -------------------- */
void drawTriangleBoundary()
{
  glClear(GL_COLOR_BUFFER_BIT);

  // Boundary Color = Black
  glColor3f(0.0f, 0.0f, 0.0f);

  glBegin(GL_LINE_LOOP);
  glVertex2i(200, 200);
  glVertex2i(400, 200);
  glVertex2i(300, 400);
  glEnd();

  glFlush();
}

/* -------------------- Mouse Click Handler -------------------- */
void handleMouseClick(int button, int state, int mouseX, int mouseY)
{
  if (button == GLUT_LEFT_BUTTON && state == GLUT_DOWN)
  {
    float fillColorRGB[3] = {1.0f, 0.0f, 0.0f};     // Red
    float boundaryColorRGB[3] = {0.0f, 0.0f, 0.0f}; // Black

    int convertedY = windowHeight - mouseY;

    performBoundaryFill(mouseX, convertedY,
                        fillColorRGB,
                        boundaryColorRGB);
  }
}

/* -------------------- Initialization -------------------- */
void initializeGraphics()
{
  glClearColor(1.0f, 1.0f, 1.0f, 1.0f); // White background
  glMatrixMode(GL_PROJECTION);
  gluOrtho2D(0, windowWidth, 0, windowHeight);
}

/* -------------------- Main Function -------------------- */
int main(int argc, char **argv)
{
  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
  glutInitWindowSize(windowWidth, windowHeight);
  glutCreateWindow("Triangle Boundary Fill - Clean Version");

  initializeGraphics();

  glutDisplayFunc(drawTriangleBoundary);
  glutMouseFunc(handleMouseClick);

  glutMainLoop();
  return 0;
}